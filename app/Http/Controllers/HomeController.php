<?php

namespace App\Http\Controllers;

use App\Models\{Slide, Package, Activity, Resort, Photo, Testimonial,Review};

class HomeController extends Controller
{
    public function index()
    {
        return view('home', ['slides' => Slide::where('active', 1)->orderBy('sort_order')->get(), 'packages' => Package::where('active', 1)->orderByDesc('featured')->orderBy('sort_order')->get(), 'activities' => Activity::where('active', 1)->orderBy('sort_order')->get(), 'resorts' => Resort::where('active', 1)->orderBy('sort_order')->get(), 'photos' => Photo::where('active', 1)->orderBy('sort_order')->get(), 'testimonials' => Testimonial::where('active', 1)->orderBy('sort_order')->get(), 'reviews' => Review::where('status', 'approved')->latest()->get()]);
    }
}
