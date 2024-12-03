@extends('layout.master')

@section('content')

<!-- Memasukkan Bootstrap dari CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- Container untuk seluruh konten -->
<div class="container mt-4">

    <form method="POST" action="{{ route('buku.saveeditorialpick') }}">
    @csrf
    <!-- Tabel Buku -->
    <div class="table-responsive mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Thumbnail</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
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
                    <td>
                        <form action="{{ route('buku.saveeditorialpick') }}">
                        <input type="checkbox" id="editorspick" name="editorspick" value="{{ $buku->editorial_pick }}">
                        <label for="editorspick"> Editor's pick</label><br>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

</form>
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
