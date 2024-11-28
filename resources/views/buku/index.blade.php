@extends('layout.master')

@section('content')

<!-- Memasukkan Bootstrap dari CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Menampilkan pesan sukses atau error -->
@if(Session::has('pesan'))
    <div class="alert alert-success">{{ Session::get('pesan') }}</div>
@endif
@if(Session::has('pesanUpdate'))
    <div class="alert alert-success">{{ Session::get('pesanUpdate') }}</div>
@endif
@if(Session::has('pesanDelete'))
    <div class="alert alert-success">{{ Session::get('pesanDelete') }}</div>
@endif

<!-- Tombol untuk menambah buku -->
<div class="mb-3">
    <a href="{{ route('buku.create') }}" class="btn btn-primary float-end">Tambah Buku</a>
</div>

<!-- Form pencarian buku -->
<form action="{{ route('buku.search') }}" method="get" class="mb-3 d-flex justify-content-end">
    @csrf 
    <input type="text" name="kata" class="form-control" placeholder="Cari..." style="width: 30%;">
</form>

<!-- Menampilkan hasil pencarian -->
@if(isset($cari) && count($data_buku_urut))
    <div class="alert alert-success">
        Ditemukan <strong>{{ $jumlah_buku }}</strong> data dengan kata: <strong>{{ $cari }}</strong>
    </div>
@elseif(isset($cari))
    <div class="alert alert-warning">
        <h4>Data {{ $cari }} tidak ditemukan</h4>
        <a href="{{ route('buku.index') }}" class="btn btn-warning">Kembali</a>
    </div>
@endif

<!-- Tabel Buku -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Thumbnail</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
                <th>Aksi</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku_urut as $index => $buku)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>
                    @if ($buku->filepath)
                        <img src="{{ asset($buku->filepath) }}" class="img-fluid rounded" alt="Gambar Buku" style="max-width: 80px;">
                    @endif
                </td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ number_format($buku->harga, 0, ',', '.') }}</td>
                <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                <td>
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                        @csrf 
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                    <form action="{{ route('buku.edit', $buku->id) }}" method="GET" class="d-inline">
                        <button onclick="return confirm('Yakin mau diedit?')" type="submit" class="btn btn-warning">Edit</button>
                    </form>
                    <a href="{{ route('review.create', $buku->id) }}" class="btn btn-success">Tambah Review</a>
                </td>
                <td>
                    @foreach($buku->reviews as $review)
                        <div>
                            <strong>{{ $review->user->name }}</strong>: {{ $review->review }}
                            @if($review->tags->isNotEmpty())
                                <br>Tags: 
                                @foreach($review->tags as $tag)
                                    <span class="badge bg-info">{{ $tag->name }}</span>
                                @endforeach
                            @endif
                        </div>
                        <hr>
                    @endforeach

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div>{{ $data_buku_urut->links('pagination::bootstrap-5') }}</div>

<!-- Menampilkan jumlah buku dan harga -->
<div><strong>Jumlah Buku: {{ $jumlah_buku }}</strong></div>
<p><strong>Total Buku:</strong> {{ $total_books }}</p>
<p><strong>Total Harga Semua Buku:</strong> Rp {{ number_format($total_price, 0, ',', '.') }}</p>

@endsection
