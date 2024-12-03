@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h4>Tambah Buku</h4>

    <!-- Error Messages -->
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('buku.store') }}">
        @csrf

        <!-- Judul -->
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan judul buku">
        </div>

        <!-- Penulis -->
        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" name="penulis" id="penulis" class="form-control" placeholder="Masukkan nama penulis">
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukkan harga buku">
        </div>

        <!-- Tanggal Terbit -->
        <div class="mb-3">
            <label for="tgl_terbit" class="form-label">Tanggal Terbit</label>
            <input type="date" name="tgl_terbit" id="tgl_terbit" class="form-control">
        </div>

        <!-- Thumbnail (Optional)-->
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control">
        </div>

         <!--Gallery (Optional)-->
        <div class="mb-3">
            <label for="gallery" class="form-label">Gallery</label>
            <input type="file" name="gallery[]" id="gallery" class="form-control mb-2" multiple>
            <p><label for="description">Description: </label></p>
            <textarea id="description" name="description" rows="4" cols="50"></textarea>
        </div>

        <!--Button-->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
        </div> 
    </form>
</div>
@endsection
