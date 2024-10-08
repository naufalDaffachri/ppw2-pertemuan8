<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_buku = Buku::all();

        // Menghitung jumlah total data buku
        $total_books = $data_buku->count();

        // Menghitung jumlah total harga semua buku
        $total_price = $data_buku->sum('harga');

        return view('buku.index', compact('data_buku', 'total_books', 'total_price' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    // Cari buku berdasarkan ID
    $buku = Buku::find($id);

    // Kirim data buku ke view
    return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    // Cari buku berdasarkan ID
    $buku = Buku::findOrFail($id);

    // Update data buku
    $buku->judul = $request->judul;
    $buku->penulis = $request->penulis;
    $buku->harga = $request->harga;
    $buku->tgl_terbit = $request->tgl_terbit;
    $buku->save();

    // Redirect ke halaman daftar buku dengan pesan sukses
    return redirect('/buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();

        return redirect('/buku');
    }
}
