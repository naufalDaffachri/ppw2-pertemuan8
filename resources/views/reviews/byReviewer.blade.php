@extends('layout.master')

@section('content')
    <h2>Review Buku oleh {{ $reviewer->name }}</h2>

    @if($reviews->isEmpty())
        <p>Belum ada review untuk reviewer ini.</p>
    @else
        @foreach($reviews as $review)
            <div class="review-item">
                <strong>{{ $review->book->judul }}</strong>
                <p>{{ $review->review }}</p>
                @if($review->tags->isNotEmpty())
                    <p><strong>Tags:</strong>
                        @foreach($review->tags as $tag)
                            <span class="badge bg-info">{{ $tag->name }}</span>
                        @endforeach
                    </p>
                @endif
                <hr>
            </div>
        @endforeach
    @endif
@endsection
