<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Admin') | TripNest</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="admin">
    <aside><a class="brand" href="{{ route('admin.dashboard') }}"><b>TN</b> TripNest<small>Admin Panel</small></a>
        <nav><a href="{{ route('admin.dashboard') }}">⌂ Dashboard</a>
            @foreach (['packages' => '🧳 Packages', 'slides' => '🎞 Slides', 'photos' => '📸 Photos', 'activities' => '🤿 Activities', 'resorts' => '🏨 Resorts', 'testimonials' => '⭐ Happy Customers'] as $k => $v)
                <a href="{{ route('admin.content.index', $k) }}">{{ $v }}</a>
            @endforeach

             <a href="{{ route('admin.reviews.index') }}">
                ⭐ Customer Reviews
            </a>
             <a href="{{ route('admin.settings') }}">
                ⚙ Website Settings
            </a>

            <a href="{{ route('admin.content.index', 'inquiries') }}">✉ Enquiries</a>
            <a href="{{ route('admin.travel-management.index') }}"> ✈️ Travel Management</a>
        </nav>
        <form method="POST" action="{{ route('admin.logout') }}">@csrf<button>⇥ Logout</button></form>
    </aside>
    <main>
        <header><button class="menu">☰</button><span>Welcome, {{ session('admin_name', 'Admin') }}</span><a
                href="{{ route('home') }}" target="_blank">Open Website ↗</a></header>
        @if (session('success'))
            <div class="ok">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
    <script>
        document.querySelector('.menu')?.addEventListener('click', () => document.querySelector('aside').classList.toggle(
            'open'))
    </script>
</body>

</html>
