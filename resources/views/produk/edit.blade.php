<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h2 class="text-center mb-4">Edit Produk</h2>

    <form action="{{ route('produk.update', $id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama" value="{{ $produk[$id]['nama'] }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" value="{{ $produk[$id]['harga'] }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ $produk[$id]['deskripsi'] }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar Produk</label><br>
            @if($produk[$id]['gambar'])
                <img src="{{ asset('uploads/'.$produk[$id]['gambar']) }}" width="150" class="mb-2">
            @endif
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
