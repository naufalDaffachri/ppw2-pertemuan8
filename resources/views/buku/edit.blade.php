@extends('layout.master')
@section('content') 
<div class="container">
    <h4>Edit Buku</h4>
    <form method="POST" action="{{ route('buku.update', $buku->id) }}" enctype="multipart/form-data">
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
        <input type="date" name="tgl_terbit" class="date form-control" placeholder="yyyy/mm/dd" value="{{ $buku->tgl_terbit->format('Y-m-d') }}">
    </div>

    <div class="col-span-full mt-6">
                @if ($buku->filepath != null)
                    <img src="{{ asset($buku->filepath) }}" alt="Gallery image" class="img-fluid rounded">
                @endif
                <label for="thumbnail" class="block text-sm font-medium leading-6 text-gray-900">Thumbnail</label>
                <div class="mt-2">
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
            </div>


                
                @if($buku->galleries()->count() > 0)
                <div class="gallery_items mt-5">
                    @foreach($buku->galleries()->get() as $gallery)
                        <div class="gallery_item d-inline-block position-relative mr-3 mb-3">
                            <img src="{{ asset($gallery->path) }}" alt="Gallery image" class="img-fluid rounded">
                            <form action="{{ route('buku.deleteGalleryImage', ['buku' => $buku->id, 'gallery' => $gallery->id]) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
                    <div class="btn btn-primary">
                        <a id="tambah" onclick="addFileInput()">Tambah Input data</a>
</div>

                    <script type="text/javascript">
                        function addFileInput() {
                            var div = document.getElementById('fileinput_wrapper');
                            div.innerHTML += '<input type="file" name="gallery[]" id="gallery" class="block w-full mb-5" style="margin-bottom:5px;">';
                        };
                    </script>
      </div>
      <div class="gallery_items">
        @foreach($buku->galleries()->get() as $gallery)
        <div class="gallery_item">
            <img 
            class="rounded-full object-cover object-center"
            src="{{asset($gallery->path)}}"
            alt=""
            width="400"
            />
        </div>
        @endforeach
      </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{'/buku'}}">Kembali</a>
</form>
</div>
@endsection
