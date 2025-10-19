<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran #{{ $order['id'] }}</title>
    <style>body { font-family: sans-serif; padding: 20px; } .container { max-width: 600px; margin: auto; border: 3px solid #4CAF50; padding: 30px; border-radius: 8px; text-align: center; background-color: #E8F5E9; } h2 { color: #4CAF50; } .details { text-align: left; margin-top: 25px; padding: 15px; border: 1px solid #ddd; background-color: #fff; } strong { font-weight: bold; } .status-paid { color: white; background-color: #4CAF50; padding: 5px 10px; border-radius: 5px; font-weight: bold; }</style>
</head>
<body>
    <div class="container">
        <h2>Langkah 3: Pembayaran Berhasil! ✅</h2>
        <p>Terima kasih <strong>{{ $order['client_name'] }}</strong>. Pesanan dan pembayaran Anda telah dikonfirmasi.</p>
        
        <div class="details">
            <p><strong>Status Pembayaran:</strong> <span class="status-paid">{{ $order['status'] }}</span></p>
            <p><strong>Tanggal Pembayaran:</strong> {{ $order['payment_date'] ?? 'N/A' }}</p>
            <hr>
            <p><strong>ID Pesanan:</strong> {{ $order['id'] }}</p>
            <p><strong>Nama Klien:</strong> {{ $order['client_name'] }}</p>
            <p><strong>Trainer:</strong> {{ $order['trainer']['name'] }} ({{ $order['trainer']['specialty'] }})</p>
            <p><strong>Durasi Sesi:</strong> {{ $order['duration'] }} kali</p>
            <p><strong>Total Bayar:</strong> <span style="font-size: 1.2em; font-weight: bold; color: #4CAF50;">Rp{{ number_format($order['total_price'], 0, ',', '.') }}</span></p>
        </div>

        <p style="margin-top: 20px;">Ini adalah bukti pembayaran Anda. Simpan untuk sesi pertama Anda!</p>
        <a href="{{ route('booking.form') }}">← Buat Pesanan Baru</a>
    </div>
</body>
</html>