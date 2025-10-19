<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = session('produk', []);
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produk = session('produk', []);

        // Upload gambar
        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $namaFile = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $namaFile);
        }

        $produk[] = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFile
        ];

        session(['produk' => $produk]);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = session('produk', []);
        if (!isset($produk[$id])) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan');
        }

        return view('produk.edit', compact('produk', 'id'));
    }

    public function update(Request $request, $id)
    {
        $produk = session('produk', []);
        if (!isset($produk[$id])) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan');
        }

        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'deskripsi' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Hapus gambar lama kalau ada dan upload baru
        if ($request->hasFile('gambar')) {
            $namaFileBaru = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $namaFileBaru);

            // hapus gambar lama
            $gambarLama = $produk[$id]['gambar'];
            if ($gambarLama && file_exists(public_path('uploads/' . $gambarLama))) {
                unlink(public_path('uploads/' . $gambarLama));
            }

            $produk[$id]['gambar'] = $namaFileBaru;
        }

        $produk[$id]['nama'] = $request->nama;
        $produk[$id]['harga'] = $request->harga;
        $produk[$id]['deskripsi'] = $request->deskripsi;

        session(['produk' => $produk]);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = session('produk', []);
        if (isset($produk[$id])) {
            $gambarLama = $produk[$id]['gambar'];
            if ($gambarLama && file_exists(public_path('uploads/' . $gambarLama))) {
                unlink(public_path('uploads/' . $gambarLama));
            }

            unset($produk[$id]);
            session(['produk' => array_values($produk)]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
