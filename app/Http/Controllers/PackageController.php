<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageController extends Controller
{
    public function show(Package $package)
    {
        abort_unless($package->active, 404);
        $related = Package::where('active', 1)->where('destination', $package->destination)->whereKeyNot($package->id)->take(4)->get();
        return view('package', ['package' => $package, 'related' => $related]);
    }
}
