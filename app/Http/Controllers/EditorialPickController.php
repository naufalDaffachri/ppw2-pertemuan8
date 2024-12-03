<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editorialpick;
use App\Models\Buku;

class EditorialPickController extends Controller
{
    public function create()
    {
        $book = Buku::all();  // Ambil buku berdasarkan ID
        return view('buku.editorialpick', compact('book'));  // Kirim data buku ke tampilan
    }

public function store(Request $request)
{

    $pick = EditorialPick::create([
        'editorial_pick' => (bool) request('editorial_pick')
    ]);

    return redirect('/buku')->with('pesan', 'Editorial pick berhasil ditambahkan.');
}

public function editorialpick()
    {
        $data_buku = Buku::all();
        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku_urut = Buku::with('reviews')->orderBy('id', 'desc')->paginate(5);
        $no = $batas * ($data_buku_urut -> currentPage() - 1);

        // Menghitung jumlah total data buku
        $total_books = $data_buku->count();

        // Menghitung jumlah total harga semua buku
        $total_price = $data_buku->sum('harga');

        return view('buku.editorialpick', compact('data_buku', 'total_books', 'total_price', 'data_buku_urut', 'no', 'jumlah_buku' ));
    }

    public function saveeditorialpick(Request $request)
    {
        $editorialpick = new Editorialpick();
        $editorialpick->editorial_pick = $request->editorial_pick;
    return redirect('/buku')->with('pesanUpdate', 'Data Buku Berhasil diperbarui');
    }

}
