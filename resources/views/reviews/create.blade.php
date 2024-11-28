@extends('layout.master')

@section('content')
    <div class="container">
    <h2>Tambah Review untuk Buku: {{ $book->judul }}</h2>

<form action="{{ route('review.store', $book->id) }}" method="POST">
    @csrf
    <input type="hidden" name="book_id" value="{{ $book->id }}">
            
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea name="review" id="review" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="tags">Tags:</label>
                <input type="text" name="tags[]" class="form-control" placeholder="Enter tags separated by commas">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Submit Review</button>
        </form>
    </div>
@endsection


