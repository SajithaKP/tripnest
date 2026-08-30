@extends('layouts.app') @section('title', 'Lakshadweep & India Holiday Packages') @section('content')
{{-- <section id="home" class="hero">
    <div class="slides">
        @foreach ($slides as $i => $s)
            <article class="slide {{ $i === 0 ? 'active' : '' }}">
                @if ($s->media_type === 'video')
                    <video autoplay muted loop playsinline
                        @if ($s->poster_path) poster="{{ asset('storage/' . $s->poster_path) }}" @endif>
                        <source
                            src="{{ str_starts_with($s->media_path, 'http') ? $s->media_path : asset('storage/' . $s->media_path) }}">
                </video>@else<img
                        src="{{ str_starts_with($s->media_path, 'http') ? $s->media_path : asset('storage/' . $s->media_path) }}"
                        alt="{{ $s->title }}">
                @endif
                <div class="shade">
                </div>
                <div class="heroText container"><small>TRAVEL WITH TRIPNEST</small>
                    <h1>{{ $s->title }}</h1>
                    <p>{{ $s->subtitle }}</p><a class="lime"
                        href="{{ $s->button_url ?: '#packages' }}">{{ $s->button_text ?: 'Explore' }} →</a>
                </div>
            </article>
        @endforeach
    </div>
    <div class="dots">
        @foreach ($slides as $i => $s)
            <button data-i="{{ $i }}"></button>
        @endforeach
    </div>
    <div class="wave"></div>
</section> --}}
<section id="home" class="hero">

    <div class="slides">

        @foreach ($slides as $i => $s)

            <article class="slide {{ $i === 0 ? 'active' : '' }}">

                {{-- Slide Image / Video --}}
                @if ($s->media_type === 'video')

                    <video autoplay muted loop playsinline
                        @if ($s->poster_path)
                            poster="{{ asset('storage/' . $s->poster_path) }}"
                        @endif>
                        <source src="{{ str_starts_with($s->media_path, 'http')
                            ? $s->media_path
                            : asset('storage/' . $s->media_path) }}">
                    </video>

                @else

                    <img
                        src="{{ str_starts_with($s->media_path, 'http')
                            ? $s->media_path
                            : asset('storage/' . $s->media_path) }}"
                        alt="{{ $s->title }}">

                @endif


                {{-- Dark overlay --}}
                <div class="shade"></div>


                {{-- Slide Content --}}
                <div class="heroText container">

                    <small>
                        EXPLORE · DREAM · DISCOVER
                    </small>

                    <h1>
                        {{ $s->title }}
                    </h1>

                    <p>
                        {{ $s->subtitle }}
                    </p>


                    <div class="hero-buttons">

                        <a class="lime"
                           href="{{ $s->button_url ?: '#packages' }}">
                            {{ $s->button_text ?: 'Explore Packages' }}
                            →
                        </a>

                        <a class="hero-outline"
                           href="#contact">
                            Plan My Trip
                        </a>

                    </div>

                </div>

            </article>

        @endforeach

    </div>


    {{-- Slider dots --}}
    <div class="dots">

        @foreach ($slides as $i => $s)

            <button data-i="{{ $i }}"></button>

        @endforeach

    </div>


    <div class="wave"></div>

</section>
<section id="packages" class="section mint">
    <div class="container">
        <div class="head"><small>FEATURED DESTINATIONS</small>
            <h2>Choose your next <i>escape</i></h2>
            <p>Island beaches, mountains, backwaters and international journeys planned by TripNest.</p>
        </div>
        <div class="filters"><button data-f="all" class="active">All</button>
            @foreach ($packages->pluck('destination')->unique() as $d)
                <button data-f="{{ Str::slug($d) }}">{{ $d }}</button>
            @endforeach
        </div>
        <div class="grid3">
            @foreach ($packages as $p)
                <article class="card pkg" data-d="{{ Str::slug($p->destination) }}">
                    <div class="pic"><img
                            src="{{ str_starts_with($p->featured_image, 'http') ? $p->featured_image : asset('storage/' . $p->featured_image) }}"
                            alt="{{ $p->title }}">
                        @if ($p->featured)
                            <b>Popular</b>
                        @endif
                        <span>
                            {{ $p->destination }}</span>
                    </div>
                    <div class="body"><em>★★★★★</em>
                        <h3>{{ $p->title }}</h3>
                        <p>{{ $p->short_description }}</p><small>🕐 {{ $p->duration }} · 👥
                            {{ $p->category }}</small>
                        <div class="price"><strong>₹{{ number_format($p->price) }}</strong><a
                                href="{{ route('packages.show', $p) }}">→</a></div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<section id="lakshadweep" class="split">
    <div class="container splitin">
        <div><small>TRIPNEST SPECIAL</small>
            <h2>Fall in love with <i>Lakshadweep</i></h2>
            <p>Turquoise lagoons, white beaches, coral reefs and slow island mornings. Choose single, group,
                ladies-only, student, family, honeymoon or retirement tours.</p>
            <div class="stats"><b>7+<small>Tour styles</small></b><b>8+<small>Experiences</small></b><b>24/7<small>Trip
                        support</small></b></div><a class="aqua" href="#contact">Build My Lakshadweep Trip →</a>
        </div>
        <div class="island">
            <div><img
                    src="{{ $photos->first() ? (str_starts_with($photos->first()->image_path, 'http') ? $photos->first()->image_path : asset('storage/' . $photos->first()->image_path)) : '' }}">
            </div><span>🌴</span><b>Island life<small>Sea · Sand · Sun</small></b>
        </div>
    </div>
</section>
<section id="activities" class="section teal">
    <div class="container">
        <div class="head light"><small>LAKSHADWEEP EXPERIENCES</small>
            <h2>Make every island day <i>count</i></h2>
            <p>Sunrise, sunset, scuba, fishing, island views and more.</p>
        </div>
        <div class="grid4">
            @foreach ($activities as $a)
                <article class="activity"><img
                        src="{{ str_starts_with($a->image_path, 'http') ? $a->image_path : asset('storage/' . $a->image_path) }}"
                        alt="{{ $a->title }}"><b>{{ $a->icon }}</b>
                    <div><small>{{ $a->location }}</small>
                        <h3>{{ $a->title }}</h3>
                        <p>{{ $a->description }}</p><strong>₹{{ number_format($a->price) }}</strong> ·
                        {{ $a->duration }}
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<section id="resorts" class="section cream">
    <div class="container">
        <div class="head"><small>STAY YOUR WAY</small>
            <h2>Handpicked <i>resorts</i></h2>
            <p>Comfortable stays selected to make your holiday even better.</p>
        </div>
        <div class="grid4">
            @foreach ($resorts as $r)
                <article class="resort"><img
                        src="{{ str_starts_with($r->image_path, 'http') ? $r->image_path : asset('storage/' . $r->image_path) }}"
                        alt="{{ $r->name }}">
                    <div><em>★ {{ $r->rating }}</em>
                        <h3>{{ $r->name }}</h3><small>📍 {{ $r->location }}</small>
                        <p>{{ $r->description }}</p><strong>From ₹{{ number_format($r->price_from) }}</strong>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
<section id="gallery" class="section">
    <div class="container">
        <div class="head"><small>TRIPNEST MOMENTS</small>
            <h2>Postcard-worthy <i>places</i></h2>
        </div>
        <div class="gallery">
            @foreach ($photos as $p)
                <figure><img
                        src="{{ str_starts_with($p->image_path, 'http') ? $p->image_path : asset('storage/' . $p->image_path) }}"
                        alt="{{ $p->title }}">
                    <figcaption><b>{{ $p->title }}</b><small>{{ $p->destination }}</small></figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
{{-- <section class="testimonials">
    <div class="container">
        <div class="head light"><small>OUR HAPPY CUSTOMERS</small>
            <h2>Stories from the <i>road</i></h2>
        </div>
        <div class="grid3">
            @foreach ($testimonials as $t)
                <article class="quote"><em>{{ str_repeat('★', $t->rating) }}</em>
                    <p>“{{ $t->message }}”</p><b>{{ $t->customer_name }}</b><small>{{ $t->location }}</small>
                </article>
            @endforeach
        </div>
    </div>
</section> --}}
<section class="reviews-section">

    <div class="section-heading">

        <small>OUR CLIENTS SAY</small>

        <h2>Happy Customers</h2>

        <p>
            Real experiences from TripNest travellers.
        </p>

    </div>


    <div class="reviews-grid">

        @forelse($reviews as $review)

            <article class="review-card">

                @if($review->photo)

                    <img
                        src="{{ asset('storage/' . $review->photo) }}"
                        alt="{{ $review->name }}"
                        class="review-photo"
                    >

                @endif


                <div class="review-stars">
                    {{ str_repeat('★', $review->rating) }}
                </div>


                <p class="review-text">
                    "{{ $review->review }}"
                </p>


                <h3>
                    {{ $review->name }}
                </h3>


                <small>
                    {{ $review->package_name }}
                </small>

            </article>

        @empty

            <p class="no-reviews">
                Our customer experiences will appear here soon.
            </p>

        @endforelse

    </div>


    {{-- SHARE REVIEW BUTTON --}}

    <div class="review-action">

        <a
            href="{{ route('review.create') }}"
            class="review-btn"
        >
            <span>✦</span>
            Share Your Experience
            <span>→</span>
        </a>

    </div>

</section>
<section class="final">
    <div class="container"><small>IT'S TIME TO TRAVEL</small>
        <h2>Chasing waves,<br><i>collecting memories.</i></h2><a class="lime" href="#contact">Let's Plan Your Trip
            →</a>
    </div>
</section>
<section id="contact" class="contact">
    <div class="container contactin">
        <div><small>LET'S TALK TRAVEL</small>
            <h2>Tell us where you want to <i>go.</i></h2>
            <p>Send your requirements and our team will contact you with dates, package options and pricing.</p>
            <div class="points"><b>📞 +91 96339 14161</b><b>✉ hello@tripnest.in</b><b>📍 Kerala, India</b></div>
        </div>
        <form method="POST" action="{{ route('contact.store') }}">@csrf<label>Name<input name="name"
                    required></label>
            <div class="tw"><label>Phone<input name="phone" required></label><label>Email<input type="email"
                        name="email" required></label></div>
            <div class="tw"><label>Travel date<input type="date"
                        name="travel_date"></label><label>Travellers<input type="number" name="travellers"
                        min="1"></label></div><label>Package / Destination<input name="package_name"
                    placeholder="Lakshadweep Honeymoon"></label><label>Message
                <textarea name="message" rows="4" placeholder="Tell us your dates, budget and preferences..."></textarea>
            </label>
            @if ($errors->any())
                <div class="errors">{{ $errors->first() }}</div>
            @endif
            <button class="aqua full">Send Enquiry →</button>
        </form>
    </div>
</section>
@endsection
