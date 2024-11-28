@extends('layout.master')

@section('content')
    <h1>Review untuk Tag: {{ $tag->name }}</h1>
    
    @foreach($reviews as $review)
        <div>
            <strong>{{ $review->user->name }}</strong>: {{ $review->review }}
            <br>
            Buku: {{ $review->book->judul }}
            @if($review->tags->isNotEmpty())
                <br>Tags:
                @foreach($review->tags as $tag)
                    <span class="badge bg-info">{{ $tag->name }}</span>
                @endforeach
            @endif
        </div>
        <hr>
    @endforeach
@endsection

