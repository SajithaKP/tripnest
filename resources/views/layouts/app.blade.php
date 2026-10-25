<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!--<title>@yield('title', 'TripNest') | Travel Beyond Expectations</title>-->
    <title>@yield('title', 'TripNest | Lakshadweep & India Travel Packages')</title>

    <meta name="description"
        content="@yield('description', 'Explore Lakshadweep and India travel packages with TripNest. Discover curated holidays, island adventures, resorts and memorable travel experiences.')">
    
    <meta name="robots" content="index, follow">

<link rel="canonical" href="{{ url()->current() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tripnest.css') }}">
</head>

<body>
    @php
    $logo = \App\Models\Setting::where('key', 'logo')->first();
@endphp
    <div class="float fish">🐠</div>
    <div class="float boat">⛵</div>
    <div class="float plane">✈</div>

    <!-- Floating ocean decorations -->
<div class="float fish fish1">🐠</div>
<div class="float fish fish2">🐟</div>
<div class="float fish fish3">🐡</div>

<div class="float boat">⛵</div>
{{-- <div class="float plane">✈️</div> --}}

<!-- Bubbles -->
<div class="bubble bubble1"></div>
<div class="bubble bubble2"></div>
<div class="bubble bubble3"></div>
<div class="bubble bubble4"></div>
<div class="bubble bubble5"></div>
<div class="bubble bubble6"></div>
<div class="bubble bubble7"></div>
<div class="bubble bubble8"></div>

<!-- Small sea decorations -->
<div class="sea-decoration shell1">🐚</div>
<div class="sea-decoration shell2">🪸</div>
<div class="sea-decoration star1">⭐</div>
<div class="sea-decoration star2">✦</div>
    <header>
        <div class="nav container">
            {{-- <a class="logo" href="{{ route('home') }}"><b>TN</b><span>TripNest<small>Travel &
                        Holidays</small></span>
                    </a> --}}
                    <a class="logo" href="{{ route('home') }}">

                            @if($logo && $logo->value)

                                <img
                                    src="{{ asset('storage/' . $logo->value) }}"
                                    alt="TripNest Logo"
                                    class="site-logo"
                                >

                            @else

                                <b>TN</b>
                             @endif
                                <span>
                                    TripNest
                                    <small>Travel & Holidays</small>
                                </span>

                          

                        </a>
                    <button class="hamb">☰</button>
            <nav><a href="{{ route('home') }}#home">Home</a><a href="{{ route('home') }}#packages">Packages</a><a
                    href="{{ route('home') }}#lakshadweep">Lakshadweep</a><a
                    href="{{ route('home') }}#activities">Activities</a><a
                    href="{{ route('home') }}#resorts">Resorts</a><a href="{{ route('home') }}#gallery">Gallery</a><a
                    class="navbtn" href="{{ route('home') }}#contact">Plan My Trip</a></nav>
        </div>
    </header>
    @if (session('success'))
        <div class="toast">{{ session('success') }}</div>
    @endif
    <main>@yield('content')</main>
    <footer>
        <div class="container foot">
            <div>
                {{-- <a class="logo" href="{{ route('home') }}"><b>TN</b><span>TripNest<small>Travel &
                            Holidays</small></span></a> --}}
                            <a class="logo" href="{{ route('home') }}">

                                @if($logo && $logo->value)

                                    <img
                                        src="{{ asset('storage/' . $logo->value) }}"
                                        alt="TripNest Logo"
                                        class="site-logo"
                                    >

                                @else

                                    <b>TN</b>
                                   @endif
                                    <span>
                                        TripNest
                                        <small>Travel & Holidays</small>
                                    </span>

                            </a>
                <p>Curated holidays, island adventures and memorable journeys.</p>
            </div>
            <div>
                <h4>Destinations</h4><a href="{{ route('home') }}#packages">Lakshadweep</a><a
                    href="{{ route('home') }}#packages">Kerala</a><a href="{{ route('home') }}#packages">Kashmir</a><a
                    href="{{ route('home') }}#packages">Manali</a>
            </div>
            <div>
                <h4>International</h4><a href="{{ route('home') }}#packages">Malaysia</a><a
                    href="{{ route('home') }}#packages">Umrah</a><a href="{{ route('home') }}#contact">Custom
                    Tours</a>
            </div>
    
            <div class="footer-contact">

                <h4>Contact</h4>

                <a href="tel:+918301022346">
                    <span>📞</span>
                    <span>+91 8301022346</span>
                </a>

                <a
                    href="https://wa.me/918301022346?text=Hello%20TripNest%2C%20I%20would%20like%20to%20know%20about%20your%20tour%20packages."
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <span>💬</span>
                    <span>WhatsApp Us</span>
                </a>

                <a href="mailto:tripnesr786@gmail.com">
                    <span>✉</span>
                    <span>tripnest786@gmail.com</span>
                </a>

                <a href="https://instagram.com/YOUR_INSTAGRAM_USERNAME"
                target="_blank"
                rel="noopener noreferrer">
                    <span>📸</span>
                    <span>Instagram</span>
                </a>

                <p>
                    📍 Lakshadweep, India
                </p>

            </div>
        </div>
        <div class="copy">© {{ date('Y') }} TripNest. All rights reserved.</div>
    </footer>
    <script src="{{ asset('js/tripnest.js') }}"></script>
</body>

</html>
