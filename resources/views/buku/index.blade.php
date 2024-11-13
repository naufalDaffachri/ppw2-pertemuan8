@extends('layout.master')

@section('content')
    <div class="mb-3">
    <a href="{{ route('buku.create') }}" class="btn btn-primary float-end">Tambah Buku</a>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @if(Session::has('pesan'))
    <div class="alert alert-success"> {{Session::get('pesan')}}</div>
    @endif
    @if(Session::has('pesanUpdate'))
    <div class="alert alert-success"> {{Session::get('pesanUpdate')}}</div>
    @endif
    @if(Session::has('pesanDelete'))
    <div class="alert alert-success"> {{Session::get('pesanDelete')}}</div>
    @endif

    <form action=" {{ route('buku.search') }}" method="get">@csrf 
        <input type="text" name="kata" class="form-control" placeholder="Cari..." style="width: 30%;
        display: inline; margin-top: 10px; margin-bottom: 10px; float: right;">
    </form>

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
    
    <table class="table table-stripped">
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
            @foreach($data_buku_urut as $index => $buku)
            @if($buku->filepath)
        @endif
            <tr>
                <td>{{ $index+1}}</td>
                <td>
                    @if ($buku->filepath)
                        <div class="relative h-10 w-10">
                            <img 
                                class="h-full w-full rounded-full object-cover object-center" 
                                src="{{ asset($buku->filepath) }}" 
                                alt="Gambar Buku"
                            />
                        </div>
                    @endif

                <td>{{$buku->judul}}</td>
                <td>{{$buku->penulis}}</td>
                <td>{{ number_format($buku->harga, 0, ',', '.') }}</td>
                <td>{{ $buku->tgl_terbit->format('d/m/Y')}}</td>
                <td> 
                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                @csrf 
                @method('DELETE')
                <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <form action="{{ route('buku.edit', $buku->id) }}" method="GET" class="d-inline">
                <button onclick="return confirm('Yakin mau diedit?')" type="submit" class="btn btn-warning">Edit</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>{{$data_buku_urut -> links('pagination::bootstrap-5') }}</div>
    <div><strong>Jumlah Buku: {{ $jumlah_buku }}</strong></div>
    <!-- Menampilkan jumlah total data buku -->
    <p><strong>Total Buku:</strong> {{ $total_books }}</p>
    <!-- Menampilkan jumlah total harga semua buku -->
    <p><strong>Total Harga Semua Buku:</strong> Rp {{ number_format($total_price, 0, ',', '.') }}</p>
    
    @endsection