@extends('layout.master')

@section('content')

<!-- Memasukkan Bootstrap dari CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Container untuk seluruh konten -->
<div class="container mt-4">

    <!-- Form Pencarian -->
    <div class="mb-3">
        <form action="{{ route('buku.search') }}" method="GET" class="d-flex">
            <input type="text" name="kata" class="form-control" placeholder="Cari Buku..." value="{{ old('cari', $cari ?? '') }}">
            <button type="submit" class="btn btn-primary ms-2">Cari</button>
        </form>
    </div>

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

    <div class="mb-3 text-end">
        <a href="{{ route('buku.editorialpick') }}" class="btn btn-primary">Tambah Editorial Pick</a>
    </div>

    <!-- Tombol untuk menambah buku -->
    <div class="mb-3 text-end">
        <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
    </div>

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
    <div class="table-responsive mt-3">
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
                    <th>Editor's Pick</th>
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
                    <td><del>{{ number_format($buku->harga, 0, ',', '.') }}</del><span class="badge bg-success">{{'30% off'}}</span></td>
                    <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        <form action="{{ route('buku.edit', $buku->id) }}" method="GET" class="d-inline">
                            <button onclick="return confirm('Yakin mau diedit?')" type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>
                        <a href="{{ route('review.create', $buku->id) }}" class="btn btn-success btn-sm">Tambah Review</a>
                    </td>
                    <td>
                        @foreach($buku->reviews as $review)
                        <div class="mb-2">
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
                    <td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">{{ $data_buku_urut->links('pagination::bootstrap-5') }}</div>

    <!-- Menampilkan jumlah buku dan harga -->
    <div class="mt-4">
        <strong>Jumlah Buku: {{ $jumlah_buku }}</strong>
    </div>
    <p><strong>Total Buku:</strong> {{ $total_books }}</p>
    <p><strong>Total Harga Semua Buku:</strong> Rp {{ number_format($total_price, 0, ',', '.') }}</p>

</div>

@endsection
