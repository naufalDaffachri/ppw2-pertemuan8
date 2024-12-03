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
        $data_buku_urut = Buku::with('reviews')->orderBy('id', 'desc')->paginate(5);
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
        $request->validate([
            'judul'       => 'required|string',
            'penulis'     => 'required|string|max:30',
            'harga'       => 'required|numeric',
            'tgl_terbit'  => 'required|date',
            'thumbnail'   => 'image|mimes:jpeg,jpg,png|max:2048',
            'gallery.*'   => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;

        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . ' ' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = $thumbnailFile->storeAs('uploads', $thumbnailName, 'public');

            Image::make(storage_path('app/public/uploads/' . $thumbnailName))
                ->fit(240, 320)
                ->save();

            $buku->filename = $thumbnailName;
            $buku->filepath = '/storage/' . $thumbnailPath;
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $fileName = time() . ' ' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                Gallery::create([
                    'nama_galeri' => $fileName,
                    'path'        => '/storage/' . $filePath,
                    'foto'        => $fileName,
                    'buku_id'     => $buku->id
                ]);
            }
        }
        
        $buku->save();

        return redirect('/buku')->with('pesan', 'Data buku berhasil disimpan');
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
        $cari = $request->input('kata');  // Mengambil input pencarian dari form
        
        // Pastikan kita melakukan pencarian yang benar pada kolom yang diinginkan
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")
                         ->orWhere('penulis', 'like', "%".$cari."%")
                         ->paginate($batas);
    
        $jumlah_buku = $data_buku->count();
        $no = $batas * ($data_buku->currentPage() - 1);
        
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
