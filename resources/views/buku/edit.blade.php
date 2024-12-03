@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h4>Edit Buku</h4>
    
    <form method="POST" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ $buku->judul }}">
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" name="penulis" id="penulis" class="form-control" value="{{ $buku->penulis }}">
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="{{ $buku->harga }}">
        </div>

        <div class="mb-3">
            <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" name="tgl_terbit" id="tgl_terbit" class="form-control" value="{{ $buku->tgl_terbit->format('Y-m-d') }}">
        </div>

        <!-- Thumbnail Upload -->
        <div class="mb-3">
            @if ($buku->filepath)
                <div class="mb-3">
                    <img src="{{ asset($buku->filepath) }}" alt="Gambar Buku" class="img-fluid rounded mb-3" style="max-width: 150px;">
                </div>
            @endif
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control">
        </div>

        <!-- Gallery Images -->
        @if($buku->galleries()->count() > 0)
            <div class="mb-3">
                <label class="form-label">Gambar Galeri</label>
                <div class="gallery_items mb-3">
                    @foreach($buku->galleries as $gallery)
                        <div class="gallery_item d-inline-block position-relative mr-3 mb-3">
                            <img src="{{ asset($gallery->path) }}" alt="Gallery image" class="img-fluid rounded" style="max-width: 150px;">
                            <form action="{{ route('buku.deleteGalleryImage', ['buku' => $buku->id, 'gallery' => $gallery->id]) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Add New Gallery Image Input -->
        <div class="mb-3" id="fileinput_wrapper">
            <label for="gallery" class="form-label">Tambah Gambar Galeri</label>
            <input type="file" name="gallery[]" id="gallery" class="form-control mb-3">
            <p><label for="description">Description: </label></p>
            <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
            <button type="button" class="btn btn-secondary" onclick="addFileInput()">Tambah Input Data</button>
        </div>

        <script type="text/javascript">
            function addFileInput() {
                var div = document.getElementById('fileinput_wrapper');
                div.innerHTML += '<input type="file" name="gallery[]" class="form-control mb-3">';
            };
        </script>

        <!-- Save and Cancel buttons -->
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
