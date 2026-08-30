<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }
    public function login(Request $r)
    {
        $d = $r->validate(['email' => 'required|email', 'password' => 'required']);
        $a = Admin::where('email', $d['email'])->first();
        if (!$a || !Hash::check($d['password'], $a->password)) return back()->withErrors(['email' => 'Invalid admin credentials.']);
        $r->session()->regenerate();
        $r->session()->put(['admin_id' => $a->id, 'admin_name' => $a->name]);
        return redirect()->route('admin.dashboard');
    }
    public function logout(Request $r)
    {
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
