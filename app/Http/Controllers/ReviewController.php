<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($artisan)
    {
        $reviews = Review::where('artisan_id', $artisan)->with('user')->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request, $project)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'project_id' => $project,
            'artisan_id' => $request->artisan_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
