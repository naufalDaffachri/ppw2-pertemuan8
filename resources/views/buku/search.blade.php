@extends('layout.master')

@section('content')
@if(count($data_buku))
<div class="alert alert-success">Ditemukan <strong>{{count($data_buku)}}</strong> data dengan kata: <strong>{{ $cari }}</strong></div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>id</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tanggal Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data_buku as $index => $buku)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $buku->judul }}</td>
            <td>{{ $buku->penulis }}</td>
            <td>{{ number_format($buku->harga, 0, ',', '.') }}</td>
            <td>{{ $buku->tgl_terbit->format('d/m/Y') }}</td>
            <td>
                <!-- Tombol aksi -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div>{{ $data_buku->links('pagination::bootstrap-5') }}</div>
@else
<div class="alert alert-warning">
    <h4>Data {{ $cari }} tidak ditemukan</h4>
    <a href="/buku" class="btn btn-warning">Kembali</a>
</div>
@endif
@endsection