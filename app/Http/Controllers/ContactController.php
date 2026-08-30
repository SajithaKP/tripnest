<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $r)
    {
        $d = $r->validate(['name' => 'required|max:120', 'email' => 'required|email|max:160', 'phone' => 'required|max:30', 'travel_date' => 'nullable|date', 'travellers' => 'nullable|integer|min:1|max:100', 'package_name' => 'nullable|max:160', 'message' => 'nullable|max:2000']);
        Inquiry::create($d);
        return back()->with('success', 'Thank you! Your enquiry was received. We will contact you soon.');
    }
}
