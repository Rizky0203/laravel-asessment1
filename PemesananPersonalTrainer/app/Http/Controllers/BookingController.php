<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    // Data Trainer (Pengganti Database - Array)
    protected $trainers = [
        'PT001' => ['name' => 'Budi Perkasa', 'price' => 500000, 'specialty' => 'Strength Training'],
        'PT002' => ['name' => 'Ani Lestari', 'price' => 650000, 'specialty' => 'Yoga & Flexibility'],
        'PT003' => ['name' => 'Joko Susanto', 'price' => 450000, 'specialty' => 'Weight Loss'],
    ];

    // Detail Bank Statis untuk Simulasi Virtual Account
    protected $bankDetails = [
        'bank_name' => 'Bank ABC',
        'va_prefix' => '9876' 
    ];

    // Fungsi Pembantu: Mengambil semua pesanan dari session
    private function getOrders()
    {
        return Session::get('orders', []);
    }

    // Fungsi Pembantu: Menyimpan pesanan ke session
    private function saveOrders($orders)
    {
        Session::put('orders', $orders);
    }
    
    // 1. Menampilkan Form Pemesanan
    public function index()
    {
        return view('booking.form', [
            'trainers' => $this->trainers
        ]);
    }

    // 2. Memproses Pemesanan dan Menyimpan ke Session
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'trainer_id' => 'required|in:' . implode(',', array_keys($this->trainers)),
            'client_name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:10',
        ]);

        $trainer = $this->trainers[$request->trainer_id];
        $orderId = 'ORD-' . time(); 
        $totalPrice = $trainer['price'] * $request->duration;
        $paymentCode = rand(100000, 999999); // Kode unik untuk VA

        $orderData = [
            'id' => $orderId,
            'client_name' => $request->client_name,
            'trainer' => $trainer,
            'duration' => $request->duration,
            'total_price' => $totalPrice,
            'payment_code' => $paymentCode,
            'status' => 'Pending', // Status awal
        ];

        // Simpan data pesanan ke Session
        $orders = $this->getOrders();
        $orders[$orderId] = $orderData;
        $this->saveOrders($orders);

        // Redirect ke halaman pembayaran
        return redirect()->route('booking.payment', ['orderId' => $orderId]);
    }

    // 3. Halaman Pembayaran (Virtual Account Simulasi)
    public function payment($orderId)
    {
        $orders = $this->getOrders();

        if (!isset($orders[$orderId])) {
            return redirect()->route('booking.form')->with('error', 'Pesanan tidak ditemukan.');
        }

        $order = $orders[$orderId];
        
        // Gabungkan VA Prefix dengan Kode Pembayaran
        $virtualAccount = $this->bankDetails['va_prefix'] . $order['payment_code'];

        return view('booking.payment', [
            'order' => $order,
            'bankDetails' => $this->bankDetails,
            'virtualAccount' => $virtualAccount,
        ]);
    }

    // 4. Konfirmasi Pembayaran / Bukti Pembayaran
    public function confirm($orderId)
    {
        $orders = $this->getOrders();

        if (!isset($orders[$orderId])) {
            return redirect()->route('booking.form')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Cek dan ubah status jika masih Pending
        if ($orders[$orderId]['status'] !== 'Paid') {
            $orders[$orderId]['status'] = 'Paid';
            $orders[$orderId]['payment_date'] = now()->format('d M Y H:i:s');
            $this->saveOrders($orders); // Simpan perubahan status ke Session
        }

        // Tampilkan bukti pembayaran
        return view('booking.proof', [
            'order' => $orders[$orderId], 
            'is_confirmed' => true
        ]);
    }
}