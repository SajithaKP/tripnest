@extends('admin.layout') @section('title', ucfirst($type)) @section('content')<div class="page">
    <div class="pagehead">
        <div><small>CONTENT MANAGEMENT</small>
            <h1>{{ ucfirst($type) }}</h1>
            <p>Manage {{ $type }} displayed on the website.</p>
        </div><a class="btn" href="{{ route('admin.content.create', $type) }}">+ Add</a>
    </div>
    <section class="panel">
        <div class="table">
            <table>
                <tr>
                    <th>Preview</th>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tr>
                @foreach ($items as $x)
                    <tr>
                        <td>@php $img=$x->featured_image??$x->image_path??$x->photo_path??$x->media_path??null; @endphp @if ($img)
                                <img class="thumb" src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}">
                            @endif
                        </td>
                        <td><b>{{ $x->title ?? ($x->name ?? $x->customer_name) }}</b><small>{{ $x->description ?? ($x->message ?? ($x->subtitle ?? '')) }}</small>
                        </td>
                        <td>{{ $x->destination ?? ($x->location ?? ($x->category ?? '')) }} @if (isset($x->price))
                                · ₹{{ number_format($x->price) }}
                            @endif
                        </td>
                        <td><a href="{{ route('admin.content.edit', [$type, $x->id]) }}">Edit</a>
                            <form class="inline" method="POST"
                                action="{{ route('admin.content.destroy', [$type, $x->id]) }}">@csrf
                                @method('DELETE')<button onclick="return confirm('Delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>{{ $items->links() }}
    </section>
</div>@endsection
