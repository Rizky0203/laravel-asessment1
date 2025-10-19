<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pesanan #{{ $order['id'] }}</title>
    <style>body { font-family: sans-serif; padding: 20px; } .container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; text-align: center; } .details { text-align: left; margin-top: 20px; padding: 15px; border: 1px dashed #000; display: inline-block; } h2 { color: #FF9800; } .va-box { margin: 25px 0; border: 2px solid #4CAF50; padding: 15px; background-color: #f0fff0; } .va-number { font-size: 2em; font-weight: bold; color: #4CAF50; }</style>
</head>
<body>
    <div class="container">
        <h2>Langkah 2: Pembayaran (Transfer Virtual Account) 💰</h2>
        <p>Halo, <strong>{{ $order['client_name'] }}</strong>. Silakan selesaikan pembayaran untuk pesanan ini.</p>
        
        <div class="details">
            <p><strong>ID Pesanan:</strong> {{ $order['id'] }}</p>
            <p><strong>Nama Trainer:</strong> {{ $order['trainer']['name'] }}</p>
            <p><strong>Durasi Sesi:</strong> {{ $order['duration'] }} kali</p>
            <p><strong>Total Pembayaran:</strong> 
                <span style="font-size: 1.5em; color: #E91E63; font-weight: bold;">
                    Rp{{ number_format($order['total_price'], 0, ',', '.') }}
                </span>
            </p>
        </div>

        <h3>Transfer ke Virtual Account Berikut:</h3>
        
        <div class="va-box">
            <p style="margin: 5px;">Bank Tujuan:</p>
            <strong style="font-size: 1.2em;">{{ $bankDetails['bank_name'] }}</strong>
            <p style="margin: 5px; margin-top: 15px;">Nomor Virtual Account:</p>
            <div class="va-number">{{ $virtualAccount }}</div>
        </div>

        <p>Setelah melakukan transfer, klik tautan di bawah ini untuk melihat bukti pembayaran (Simulasi Konfirmasi):</p>
        <a href="{{ route('booking.confirm', ['orderId' => $order['id']]) }}">
            <strong>&rarr; Klik untuk Konfirmasi &larr;</strong>
        </a>
    </div>
</body>
</html>