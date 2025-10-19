<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
     
        body {
            background-color: #f8f9fa;
        }

        h2 {
            color: #000000ff;
            margin-bottom: 2rem;
        }

        .card {
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .btn-sm {
            min-width: 60px;
        }

        .text-muted {
            font-size: 0.85rem;
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <h2 class="text-center">Daftar Produk Merchandise</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

    <div class="row g-4">
        @forelse ($produk as $id => $item)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @if($item['gambar'])
                        <img src="{{ asset('uploads/'.$item['gambar']) }}" class="card-img-top">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $item['nama'] }}</h5>
                        <p class="card-text">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                        <p class="text-muted">{{ $item['deskripsi'] }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('produk.edit', $id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="{{ route('produk.destroy', $id) }}" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center mt-4">Belum ada produk.</p>
        @endforelse
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
