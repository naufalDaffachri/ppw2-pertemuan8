<html>
    <a href="{{ route('buku.create') }}" class="btn btn-primary float-end">Tambah Buku</a>
    <table class="table table-stripped">
        <thead>
            <tr>
            <th>id</th>
            <th>Judukl Buku</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tanggal Terbit</th>
            <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $index => $buku)
            <tr>
                <td>{{ $index+1}}</td>
                <td>{{$buku->judul}}</td>
                <td>{{$buku->penulis}}</td>
                <td>{{"Rp. ".number_format($buku->harga, 2, ',', '.')}}</td>
                <td>{{$buku->tgl_terbit->format('d/m/Y')}}</td>
                <td> 
                    <form action="{{route('buku.destroy', $buku->id) }}" method="POST">
                        @csrf 
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau dihapus?')" type="submit"
                        class="btn-btn-danger">Hapus</button>
                    </form>
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning" style="margin-left: 10px;">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Menampilkan jumlah total data buku -->
    <p><strong>Total Buku:</strong> {{ $total_books }}</p>
    <!-- Menampilkan jumlah total harga semua buku -->
    <p><strong>Total Harga Semua Buku:</strong> Rp {{ number_format($total_price, 0, ',', '.') }}</p>
</html>