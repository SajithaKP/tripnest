@extends('admin.layout') @section('title', 'Edit ' . ucfirst($type)) @section('content')<div class="page">
    <div class="pagehead">
        <div><small>CONTENT MANAGEMENT</small>
            <h1>{{ $item ? 'Edit' : 'Add' }} {{ ucfirst(Str::singular($type)) }}</h1>
        </div><a href="{{ route('admin.content.index', $type) }}">← Back</a>
    </div>
    <form class="form" method="POST" enctype="multipart/form-data"
        action="{{ $item ? route('admin.content.update', [$type, $item->id]) : route('admin.content.store', $type) }}">@csrf
        @if ($item)
            @method('PUT')
        @endif
        @if (in_array($type, ['packages', 'photos', 'activities']))
            <label>Title<input name="title" value="{{ old('title', $item->title ?? '') }}" required></label>
        @endif
        @if ($type === 'slides')
            <label>Title<input name="title" value="{{ old('title', $item->title ?? '') }}"
                    required></label><label>Subtitle<input name="subtitle"
                    value="{{ old('subtitle', $item->subtitle ?? '') }}"></label>
            <div class="tw"><label>Button text<input name="button_text"
                        value="{{ old('button_text', $item->button_text ?? '') }}"></label><label>Button URL<input
                        name="button_url" value="{{ old('button_url', $item->button_url ?? '#packages') }}"></label></div>
            <div class="tw"><label>Media type<select name="media_type">
                        <option value="image" @selected(($item->media_type ?? 'image') === 'image')>Image</option>
                        <option value="video" @selected(($item->media_type ?? '') === 'video')>Video</option>
                    </select></label><label>Media file<input type="file" name="media" accept="image/*,video/*"
                        @required(!$item)></label></div><label>Video poster<input type="file" name="poster"
                    accept="image/*"></label>
        @endif
        @if ($type === 'packages')
            <div class="tw"><label>Destination<input name="destination"
                        value="{{ old('destination', $item->destination ?? '') }}" required></label><label>Category<input
                        name="category" value="{{ old('category', $item->category ?? '') }}"></label></div>
            <div class="tw"><label>Duration<input name="duration"
                        value="{{ old('duration', $item->duration ?? '') }}"></label><label>Price<input type="number"
                        name="price" value="{{ old('price', $item->price ?? '') }}" required></label></div><label>Short
                description
                <textarea name="short_description">{{ old('short_description', $item->short_description ?? '') }}</textarea>
            </label><label>Description
                <textarea name="description" rows="6">{{ old('description', $item->description ?? '') }}</textarea>
            </label>
            <div class="tw"><label>Included
                    <textarea name="includes" rows="5">{{ old('includes', implode("\n", $item->includes ?? [])) }}</textarea>
                </label><label>Excluded
                    <textarea name="excludes" rows="5">{{ old('excludes', implode("\n", $item->excludes ?? [])) }}</textarea>
                </label></div><label>Featured image<input type="file" name="featured_image" accept="image/*"></label>
        @endif
        @if ($type === 'photos')
            <div class="tw"><label>Destination<input name="destination"
                        value="{{ old('destination', $item->destination ?? '') }}"></label><label>Image<input
                        type="file" name="image" accept="image/*" @required(!$item)></label></div><label>Caption
                <textarea name="caption">{{ old('caption', $item->caption ?? '') }}</textarea>
            </label>
        @endif
        @if ($type === 'activities')
            <div class="tw"><label>Location<input name="location"
                        value="{{ old('location', $item->location ?? '') }}"></label><label>Icon<input name="icon"
                        value="{{ old('icon', $item->icon ?? '') }}" placeholder="🤿"></label></div>
            <div class="tw"><label>Price<input type="number" name="price"
                        value="{{ old('price', $item->price ?? '') }}"></label><label>Duration<input name="duration"
                        value="{{ old('duration', $item->duration ?? '') }}"></label></div><label>Description
                <textarea name="description">{{ old('description', $item->description ?? '') }}</textarea>
            </label><label>Image<input type="file" name="image" accept="image/*" @required(!$item)></label>
        @endif
        @if ($type === 'resorts')
            <label>Name<input name="name" value="{{ old('name', $item->name ?? '') }}" required></label>
            <div class="tw"><label>Location<input name="location" value="{{ old('location', $item->location ?? '') }}"
                        required></label><label>Rating<input type="number" step=".1" max="5" name="rating"
                        value="{{ old('rating', $item->rating ?? 5) }}"></label></div><label>Description
                <textarea name="description">{{ old('description', $item->description ?? '') }}</textarea>
            </label><label>Price from<input type="number" name="price_from"
                    value="{{ old('price_from', $item->price_from ?? '') }}"></label><label>Amenities
                <textarea name="amenities" rows="5">{{ old('amenities', implode("\n", $item->amenities ?? [])) }}</textarea>
            </label><label>Image<input type="file" name="image" accept="image/*" @required(!$item)></label>
        @endif
        @if ($type === 'testimonials')
            <div class="tw"><label>Customer name<input name="customer_name"
                        value="{{ old('customer_name', $item->customer_name ?? '') }}"
                        required></label><label>Location<input name="location"
                        value="{{ old('location', $item->location ?? '') }}"></label></div><label>Rating<select
                    name="rating">
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" @selected(($item->rating ?? 5) == $i)>{{ $i }} stars
                        </option>
                    @endfor
                </select>
            </label><label>Message
                <textarea name="message" rows="6" required>{{ old('message', $item->message ?? '') }}</textarea>
            </label><label>Customer photo<input type="file" name="photo" accept="image/*"></label>
        @endif
        @if ($type !== 'inquiries')
            <label class="check"><input type="checkbox" name="active" value="1" @checked(old('active', $item?->active ?? true))>
                Published</label><label>Sort order<input type="number" name="sort_order"
                    value="{{ old('sort_order', $item->sort_order ?? 0) }}"></label>
        @endif
        <button class="btn">Save →</button>
    </form>
</div>@endsection
