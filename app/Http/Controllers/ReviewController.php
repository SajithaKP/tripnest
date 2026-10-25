<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',

            'email' => 'nullable|email|max:150',

            'phone' => 'nullable|string|max:20',

            'package_name' => 'nullable|string|max:150',

            'rating' => 'required|integer|min:1|max:5',

            'review' => 'required|string|max:2000',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('photo')) {

            $validated['photo'] = $request
                ->file('photo')
                ->store('reviews', 'public');
        }

        $validated['status'] = 'pending';

        Review::create($validated);

        return redirect()
            ->route('review.create')
            ->with(
                'success',
                'Thank you! Your review has been submitted and will be published after approval.'
            );
    }
}