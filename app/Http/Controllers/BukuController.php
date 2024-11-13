<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Image;
use App\Models\Gallery;


class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_buku = Buku::all();
        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku_urut = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku_urut -> currentPage() - 1);

        // Menghitung jumlah total data buku
        $total_books = $data_buku->count();

        // Menghitung jumlah total harga semua buku
        $total_price = $data_buku->sum('harga');

        return view('buku.index', compact('data_buku', 'total_books', 'total_price', 'data_buku_urut', 'no', 'jumlah_buku' ));
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
        $this->validate($request, [
            'judul' => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date'
        ], [
            'judul.required' => 'Judul buku harus diisi.',
            'penulis.required' => 'Nama penulis harus diisi.',
            'penulis.max' => 'Nama penulis tidak boleh lebih dari 30 karakter.',
            'harga.required' => 'Harga buku harus diisi.',
            'harga.numeric' => 'Harga buku harus berupa angka.',
            'tgl_terbit.required' => 'Tanggal terbit harus diisi.',
            'tgl_terbit.date' => 'Tanggal terbit harus dalam format tanggal yang benar.'
        ]);

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();


        return redirect('/buku')->with('pesan', 'Data Buku Berhasil disimpan');
        
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

    //tambahan pertemuan 11
    $request->validate([
        'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
    ]);


    $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
    $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

    Image::make(storage_path().'/app/public/uploads/'.$fileName)
    ->fit(240,320)
    ->save();

    $buku->update([
        'judul' => $request->judul,
        'penulis' => $request->penulis,
        'harga' => $request->harga,
        'tgl_terbit' => $request->tgl_terbit,
        'filename' => $fileName,
        'filepath' => '/storage/'.$filePath
    ]);

    if ($request->file('gallery')) {
        foreach($request->file('gallery') as $key => $file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            $gallery = Gallery::create([
                'nama_galeri' => $fileName,
                'path' => '/storage'.$filePath,
                'foto' => $fileName,
                'buku_id' => $id
            ]);
        }
    }

    // Update data buku (sebelum pertemuan 11)
    //$buku->judul = $request->judul;
    //$buku->penulis = $request->penulis;
    //$buku->harga = $request->harga;
    //$buku->tgl_terbit = $request->tgl_terbit;
    //$buku->save();

    // Redirect ke halaman daftar buku dengan pesan sukses
    return redirect('/buku')->with('pesanUpdate', 'Data Buku Berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();

        return redirect('/buku')->with('pesanDelete', 'Data Buku Berhasil dihapus');
    }

    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")->orWhere('penulis', 'like', "%".$cari."%")->paginate($batas);
        $jumlah_buku = $data_buku->count();
        $no = $batas * ($data_buku->currentPage()-1);
        return view('buku.search', compact('jumlah_buku', 'data_buku', 'no', 'cari'));
    }
    public function deleteGalleryImage(Buku $buku, Gallery $gallery){
        if ($gallery->books_id !== $buku->id) {
            return redirect()->back()->with('error', 'Gambar tidak ditemukan untuk buku ini.');
        }
        $storagePath = str_replace('/storage/', 'public/', $gallery->path);
        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }
        $gallery->delete();
        return redirect()->route('buku.edit', $buku->id)->with('pesanHapus', 'Gambar berhasil dihapus.');
    }
}
