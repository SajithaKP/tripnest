<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\{Package, Slide, Photo, Activity, Resort, Testimonial, Inquiry};

class AdminController extends Controller
{
    private array $map = ['packages' => Package::class, 'slides' => Slide::class, 'photos' => Photo::class, 'activities' => Activity::class, 'resorts' => Resort::class, 'testimonials' => Testimonial::class, 'inquiries' => Inquiry::class];
    private function model($type)
    {
        abort_unless(isset($this->map[$type]), 404);
        return $this->map[$type];
    }
    public function dashboard()
    {
        return view('admin.dashboard', ['counts' => ['packages' => Package::count(), 'slides' => Slide::count(), 'photos' => Photo::count(), 'activities' => Activity::count(), 'resorts' => Resort::count(), 'testimonials' => Testimonial::count(), 'inquiries' => Inquiry::where('status', 'new')->count()], 'inquiries' => Inquiry::latest()->take(8)->get()]);
    }
    public function index($type)
    {
        if ($type === 'inquiries') return view('admin.inquiries', ['items' => Inquiry::latest()->paginate(20)]);
        $m = $this->model($type);
        return view('admin.content', ['type' => $type, 'items' => $m::orderBy('sort_order')->paginate(15)]);
    }
    public function create($type)
    {
        $this->model($type);
        return view('admin.form', ['type' => $type, 'item' => null]);
    }
    public function edit($type, $id)
    {
        $m = $this->model($type);
        return view('admin.form', ['type' => $type, 'item' => $m::findOrFail($id)]);
    }
    private function base(Request $r, $type, $editing = false)
    {
        $rules = ['title' => 'required|max:180', 'active' => 'nullable|boolean', 'sort_order' => 'nullable|integer|min:0'];
        if ($type === 'packages') $rules += ['destination' => 'required|max:120', 'category' => 'nullable|max:120', 'short_description' => 'nullable|max:500', 'description' => 'nullable', 'duration' => 'nullable|max:80', 'price' => 'required|numeric|min:0', 'old_price' => 'nullable|numeric|min:0', 'featured_image' => ($editing ? 'nullable' : 'nullable') . '|image|max:8192', 'includes' => 'nullable', 'excludes' => 'nullable', 'featured' => 'nullable|boolean'];
        if ($type === 'slides') $rules = ['title' => 'required|max:180', 'subtitle' => 'nullable|max:255', 'button_text' => 'nullable|max:80', 'button_url' => 'nullable|max:255', 'media_type' => 'required|in:image,video', 'media' => ($editing ? 'nullable' : 'required') . '|file|max:51200|mimes:jpg,jpeg,png,webp,mp4,webm,mov', 'poster' => 'nullable|image|max:8192', 'active' => 'nullable|boolean', 'sort_order' => 'nullable|integer|min:0'];
        if ($type === 'photos') $rules += ['destination' => 'nullable|max:120', 'caption' => 'nullable|max:500', 'image' => ($editing ? 'nullable' : 'required') . '|image|max:8192'];
        if ($type === 'activities') $rules += ['location' => 'nullable|max:180', 'description' => 'nullable', 'image' => ($editing ? 'nullable' : 'required') . '|image|max:8192', 'icon' => 'nullable|max:20', 'price' => 'nullable|numeric|min:0', 'duration' => 'nullable|max:80'];
        if ($type === 'resorts') {
            $rules = ['name' => 'required|max:180', 'location' => 'required|max:180', 'description' => 'nullable', 'image' => ($editing ? 'nullable' : 'required') . '|image|max:8192', 'rating' => 'required|numeric|min:0|max:5', 'price_from' => 'nullable|numeric|min:0', 'amenities' => 'nullable', 'active' => 'nullable|boolean', 'sort_order' => 'nullable|integer|min:0'];
        }
        if ($type === 'testimonials') $rules = ['customer_name' => 'required|max:180', 'location' => 'nullable|max:180', 'message' => 'required|max:2000', 'rating' => 'required|integer|min:1|max:5', 'photo' => 'nullable|image|max:8192', 'active' => 'nullable|boolean', 'sort_order' => 'nullable|integer|min:0'];
        return $r->validate($rules);
    }
    private function upload($file, $folder)
    {
        return $file?->store($folder, 'public');
    }
    private function clean($d, $type)
    {
        foreach (['featured_image', 'media', 'poster', 'image', 'photo'] as $f) unset($d[$f]);
        if ($type === 'packages') {
            $d['includes'] = collect(preg_split('/\r\n|\r|\n/', (string)request('includes')))->map('trim')->filter()->values()->all();
            $d['excludes'] = collect(preg_split('/\r\n|\r|\n/', (string)request('excludes')))->map('trim')->filter()->values()->all();
            $d['slug'] = Str::slug($d['title']);
        }
        $d['active'] = request()->boolean('active');
        if ($type === 'packages') $d['featured'] = request()->boolean('featured');
        if ($type === 'resorts') $d['amenities'] = collect(preg_split('/\r\n|\r|\n/', (string)request('amenities')))->map('trim')->filter()->values()->all();
        return $d;
    }
    public function store(Request $r, $type)
    {
        $m = $this->model($type);
        $d = $this->clean($this->base($r, $type), $type);
        if ($type === 'packages') $d['featured_image'] = $this->upload($r->file('featured_image'), 'packages');
        if ($type === 'slides') {
            $d['media_path'] = $this->upload($r->file('media'), $r->media_type === 'video' ? 'slides/videos' : 'slides/images');
            $d['poster_path'] = $this->upload($r->file('poster'), 'slides/posters');
        }
        if ($type === 'photos') $d['image_path'] = $this->upload($r->file('image'), 'photos');
        if ($type === 'activities') $d['image_path'] = $this->upload($r->file('image'), 'activities');
        if ($type === 'resorts') $d['image_path'] = $this->upload($r->file('image'), 'resorts');
        if ($type === 'testimonials') $d['photo_path'] = $this->upload($r->file('photo'), 'testimonials');
        $m::create($d);
        return redirect()->route('admin.content.index', $type)->with('success', 'Saved successfully.');
    }
    public function update(Request $r, $type, $id)
    {
        $m = $this->model($type);
        $o = $m::findOrFail($id);
        $d = $this->clean($this->base($r, $type, true), $type);
        $map = ['packages' => ['featured_image', 'packages', 'featured_image'], 'photos' => ['image', 'photos', 'image_path'], 'activities' => ['image', 'activities', 'image_path'], 'resorts' => ['image', 'resorts', 'image_path'], 'testimonials' => ['photo', 'testimonials', 'photo_path']];
        if (isset($map[$type]) && $r->hasFile($map[$type][0])) {
            $old = $o->{$map[$type][2]};
            if ($old && !Str::startsWith($old, 'http')) Storage::disk('public')->delete($old);
            $d[$map[$type][2]] = $this->upload($r->file($map[$type][0]), $map[$type][1]);
        }
        if ($type === 'slides' && $r->hasFile('media')) {
            $old = $o->media_path;
            if ($old && !Str::startsWith($old, 'http')) Storage::disk('public')->delete($old);
            $d['media_path'] = $this->upload($r->file('media'), $r->media_type === 'video' ? 'slides/videos' : 'slides/images');
        }
        if ($type === 'slides' && $r->hasFile('poster')) $d['poster_path'] = $this->upload($r->file('poster'), 'slides/posters');
        $o->update($d);
        return redirect()->route('admin.content.index', $type)->with('success', 'Updated successfully.');
    }
    public function destroy($type, $id)
    {
        $m = $this->model($type);
        $o = $m::findOrFail($id);
        $o->delete();
        return back()->with('success', 'Deleted successfully.');
    }
}
