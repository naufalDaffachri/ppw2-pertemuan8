<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;

class BookApiController extends Controller
{
    public function index() {
        $books = Buku::latest()->paginate(5);
        return new BookResource(true, 'List Data Buku', $books);
    }
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan melalui request
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date'
        ]);

        // Jika validasi gagal, kirimkan respons error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        // Buat data buku baru
        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'tgl_terbit' => $request->tgl_terbit,
        ]);

        // Kembalikan respons berhasil dengan data buku
        return new BookResource(true, 'Buku Berhasil Ditambahkan', $buku);
    }
}
