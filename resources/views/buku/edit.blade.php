<div class="container">
    <h4>Edit Buku</h4>
    <form method="POST" action="{{ route('buku.update', $buku->id) }}">
    @csrf
    @method('PUT')

    <div>
        <label>Judul</label>
        <input type="text" name="judul" value="{{ $buku->judul }}">
    </div>

    <div>
        <label>Penulis</label>
        <input type="text" name="penulis" value="{{ $buku->penulis }}">
    </div>

    <div>
        <label>Harga</label>
        <input type="number" name="harga" value="{{ $buku->harga }}">
    </div>

    <div>
        <label>Tanggal Terbit</label>
        <input type="date" name="tgl_terbit" value="{{ $buku->tgl_terbit->format('Y-m-d') }}">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{'/buku'}}">Kembali</a>
</form>
</div>
