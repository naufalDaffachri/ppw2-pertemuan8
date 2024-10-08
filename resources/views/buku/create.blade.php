

<div class="container">
    <h4>Tambah Buku</h4>
    <form method="post" action="{{route('buku.store')}}">
@csrf
<div>Judul <input type="text" name="judul"></div>
<div>Penulis <input type="text" name="penulis"></div>
<div>Harga <input type="text" name="harga"></div>
<div>Tanggal Terbit <input type="date" name="tgl_terbit"></div>
<button type="submit">Simpan</button>
<a href="{{'/buku'}}">Kembali</a>
</form>
</div>

