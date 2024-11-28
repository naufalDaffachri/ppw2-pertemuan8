<?php

// app/Http/Controllers/ReviewController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Buku;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Menampilkan form untuk membuat review
    public function create($bookId)
    {
        $book = Buku::findOrFail($bookId);  // Ambil buku berdasarkan ID
        return view('reviews.create', compact('book'));  // Kirim data buku ke tampilan
    }

// Menyimpan review
public function store(Request $request)
{
    $request->validate([
        'book_id' => 'required|exists:books,id',
        'review' => 'required|string',
        'tags' => 'nullable|array',
    ]);

    $review = Review::create([
        'book_id' => $request->book_id,
        'user_id' => Auth::id(),
        'review' => $request->review,
    ]);

    if ($request->tags) {
        $tags = collect($request->tags)->map(function ($tag) {
            return Tag::firstOrCreate(['name' => $tag])->id;
        });
        $review->tags()->sync($tags);
    }

    return redirect('/buku')->with('pesan', 'Review berhasil ditambahkan.');
}

public function reviewsByReviewer($userId)
    {
        $reviews = Review::where('user_id', $userId)->get();  // Mendapatkan review berdasarkan user_id (reviewer)
        $reviewer = User::findOrFail($userId);  // Mendapatkan informasi user (reviewer)
        
        return view('reviews.byReviewer', compact('reviews', 'reviewer'));
    }

    public function reviewsByTag($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        $reviews = $tag->reviews; // Mendapatkan semua review yang memiliki tag ini
        
        return view('reviews.byTag', compact('reviews', 'tag'));
    }


}

