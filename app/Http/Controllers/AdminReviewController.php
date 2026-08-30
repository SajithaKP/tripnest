<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
     public function index()
    {
        $reviews = Review::latest()->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'status' => 'approved',
        ]);

        return back()->with(
            'success',
            'Review approved successfully.'
        );
    }

    public function reject(Review $review)
    {
        $review->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'Review rejected.'
        );
    }

    public function destroy(Review $review)
    {
        if ($review->photo) {
            \Storage::disk('public')->delete($review->photo);
        }

        $review->delete();

        return back()->with(
            'success',
            'Review deleted.'
        );
    }
}
