<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>TripNest Admin</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="login">
    <div class="loginArt">
        <h1>TripNest</h1>
        <p>Travel beyond expectations.</p><span>🌴</span>
    </div>
    <form method="POST" action="{{ route('admin.login.submit') }}" class="loginCard">@csrf<small>SECURE ACCESS</small>
        <h2>Admin Login</h2>
        <p>Manage packages, slides, photos and happy customer stories.</p>
        @if ($errors->any())
            <div class="err">{{ $errors->first() }}</div>
        @endif
        <label>Email<input type="email" name="email" required></label><label>Password<input type="password"
                name="password" required></label><button>Login →</button><small>Demo: admin@tripnest.test /
            password</small>
    </form>
</body>

</html>
