<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function index()
    {
        $logo = Setting::where('key', 'logo')->first();

        return view('admin.settings.index', compact('logo'));
    }


    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $setting = Setting::where('key', 'logo')->first();

        // Delete old logo
        if ($setting && $setting->value) {
            $oldPath = $setting->value;

            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Upload new logo
        $path = $request->file('logo')->store(
            'settings',
            'public'
        );

        Setting::updateOrCreate(
            ['key' => 'logo'],
            ['value' => $path]
        );

        return back()->with(
            'success',
            'Logo updated successfully.'
        );
    }
}