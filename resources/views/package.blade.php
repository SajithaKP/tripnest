@extends('layouts.app') @section('title', $package->title) @section('content')<section class="detailHero"
    style="background-image:linear-gradient(90deg,#033b58dd,#033b5833),url('{{ str_starts_with($package->featured_image, 'http') ? $package->featured_image : asset('storage/' . $package->featured_image) }}')">
    <div class="container"><small>TRIPNEST PACKAGE · {{ $package->destination }}</small>
        <h1>{{ $package->title }}</h1>
        <p>{{ $package->short_description }}</p><strong>₹{{ number_format($package->price) }} <small>/ person
                onwards</small></strong>
    </div>
</section>
<section class="section">
    <div class="container detail">
        <article><span class="chip">🕐 {{ $package->duration }}</span> <span class="chip">👥
                {{ $package->category }}</span>
            <h2>About this journey</h2>
            <p>{{ $package->description }}</p>
            <div class="inc">
                <div>
                    <h3>Included</h3>
                    @foreach ($package->includes ?? [] as $x)
                        <p>✓ {{ $x }}</p>
                    @endforeach
                </div>
                <div>
                    <h3>Not included</h3>
                    @foreach ($package->excludes ?? [] as $x)
                        <p>× {{ $x }}</p>
                    @endforeach
                </div>
            </div>
        </article>
        <aside><small>READY TO GO?</small>
            <h3>Plan this trip</h3>
            <p>Send your dates and traveller count. We will contact you with the best plan.</p><a class="aqua full"
                href="{{ route('home') }}#contact">Enquire Now →</a><a class="wa"
                href="https://wa.me/919633914161?text={{ urlencode('Hi TripNest, I am interested in ' . $package->title) }}"
                target="_blank">WhatsApp TripNest</a>
        </aside>
    </div>
</section>
@if ($related->count())
    <section class="section mint">
        <div class="container">
            <div class="head"><small>MORE FROM {{ $package->destination }}</small>
                <h2>Other <i>packages</i></h2>
            </div>
            <div class="grid3">
                @foreach ($related as $p)
                    <article class="card pkg">
                        <div class="pic"><img
                                src="{{ str_starts_with($p->featured_image, 'http') ? $p->featured_image : asset('storage/' . $p->featured_image) }}">
                        </div>
                        <div class="body">
                            <h3>{{ $p->title }}</h3><strong>₹{{ number_format($p->price) }}</strong><a
                                href="{{ route('packages.show', $p) }}">View →</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif@endsection
