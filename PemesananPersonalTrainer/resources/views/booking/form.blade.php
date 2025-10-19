<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Personal Trainer</title>
    <style>body { font-family: sans-serif; padding: 20px; } .container { max-width: 600px; margin: auto; border: 1px solid #ccc; padding: 20px; border-radius: 8px; } h2 { text-align: center; } label { display: block; margin-top: 10px; font-weight: bold; } input, select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; } button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; margin-top: 20px; width: 100%; } .trainer-info { margin-top: 15px; padding: 10px; border: 1px solid #eee; background-color: #f9f9f9; }</style>
</head>
<body>
    <div class="container">
        <h2>Langkah 1: Form Pemesanan Personal Trainer 🏋️</h2>

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('booking.store') }}">
            @csrf

            <label for="client_name">Nama Klien:</label>
            <input type="text" id="client_name" name="client_name" required value="{{ old('client_name') }}">
            @error('client_name') <small style="color: red;">{{ $message }}</small> @enderror

            <label for="trainer_id">Pilih Trainer:</label>
            <select id="trainer_id" name="trainer_id" required>
                <option value="">-- Pilih --</option>
                @foreach($trainers as $id => $trainer)
                    <option value="{{ $id }}" data-price="{{ $trainer['price'] }}" data-specialty="{{ $trainer['specialty'] }}" {{ old('trainer_id') == $id ? 'selected' : '' }}>
                        {{ $trainer['name'] }} (Rp{{ number_format($trainer['price'], 0, ',', '.') }}/Sesi)
                    </option>
                @endforeach
            </select>
            @error('trainer_id') <small style="color: red;">{{ $message }}</small> @enderror
            
            <div id="trainerDetails" class="trainer-info" style="display: none;">
                <strong>Spesialisasi:</strong> <span id="specialty"></span><br>
                <strong>Harga per Sesi:</strong> <span id="price"></span>
            </div>

            <label for="duration">Durasi (Jumlah Sesi):</label>
            <input type="number" id="duration" name="duration" required min="1" max="10" value="{{ old('duration', 1) }}">
            @error('duration') <small style="color: red;">{{ $message }}</small> @enderror

            <button type="submit">Lanjut ke Pembayaran</button>
        </form>
    </div>
    
    <script>
        document.getElementById('trainer_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const detailsDiv = document.getElementById('trainerDetails');
            
            if (selectedOption.value) {
                document.getElementById('specialty').textContent = selectedOption.getAttribute('data-specialty');
                const price = parseInt(selectedOption.getAttribute('data-price')).toLocaleString('id-ID');
                document.getElementById('price').textContent = `Rp${price}`;
                detailsDiv.style.display = 'block';
            } else {
                detailsDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html>