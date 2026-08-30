<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Share Your Experience | TripNest</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(
                180deg,
                #e9ffff,
                #ffffff
            );
            color: #123f52;
        }

        .review-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;
        }

        .review-card {
            width: 100%;
            max-width: 650px;
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0, 80, 100, .12);
        }

        .logo {
            text-align: center;
            color: #079c9b;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h1 {
            text-align: center;
            margin-bottom: 8px;
            color: #073f56;
        }

        .subtitle {
            text-align: center;
            color: #71838a;
            margin-bottom: 30px;
        }

        .success {
            background: #dff8ee;
            color: #087b65;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error {
            background: #ffe5e5;
            color: #a00000;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 13px;
            border: 1px solid #d4e4e7;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #18b8ae;
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        .stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 4px;
        }

        .stars input {
            display: none;
        }

        .stars label {
            font-size: 38px;
            color: #ccd5d7;
            cursor: pointer;
            margin: 0;
        }

        .stars label:hover,
        .stars label:hover ~ label,
        .stars input:checked ~ label {
            color: #ffb000;
        }

        .submit-btn {
            width: 100%;
            border: none;
            padding: 15px;
            border-radius: 30px;
            background: #0db5a8;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #078f87;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #078f87;
            text-decoration: none;
        }

        @media(max-width:600px) {

            .review-card {
                padding: 25px 18px;
            }

            .stars label {
                font-size: 32px;
            }

        }

    </style>

</head>

<body>

<div class="review-wrapper">

    <div class="review-card">

        <div class="logo">
            ✈ TripNest
        </div>

        <h1>Share Your Experience</h1>

        <p class="subtitle">
            Tell us about your TripNest journey
        </p>

        @if(session('success'))

            <div class="success">
                {{ session('success') }}
            </div>

        @endif

        @if($errors->any())

            <div class="error">

                @foreach($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        <form
            action="{{ route('review.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="field">

                <label>Your Name *</label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your name"
                    required
                >

            </div>


            <div class="field">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="your@email.com"
                >

            </div>


            <div class="field">

                <label>Phone</label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Your phone number"
                >

            </div>


            <div class="field">

                <label>Which trip did you take?</label>

                <select name="package_name">

                    <option value="">
                        Select your trip
                    </option>

                    <option value="Lakshadweep">
                        Lakshadweep
                    </option>

                    <option value="Delhi">
                        Delhi
                    </option>

                    <option value="Kashmir">
                        Kashmir
                    </option>

                    <option value="Manali">
                        Manali
                    </option>

                    <option value="Andaman & Nicobar">
                        Andaman & Nicobar
                    </option>

                    <option value="Kerala">
                        Kerala
                    </option>

                    <option value="Malaysia">
                        Malaysia
                    </option>

                    <option value="Umrah">
                        Umrah
                    </option>

                </select>

            </div>


            <div class="field">

                <label>Your Rating *</label>

                <div class="stars">

                    <input
                        type="radio"
                        id="star5"
                        name="rating"
                        value="5"
                    >
                    <label for="star5">★</label>

                    <input
                        type="radio"
                        id="star4"
                        name="rating"
                        value="4"
                    >
                    <label for="star4">★</label>

                    <input
                        type="radio"
                        id="star3"
                        name="rating"
                        value="3"
                    >
                    <label for="star3">★</label>

                    <input
                        type="radio"
                        id="star2"
                        name="rating"
                        value="2"
                    >
                    <label for="star2">★</label>

                    <input
                        type="radio"
                        id="star1"
                        name="rating"
                        value="1"
                    >
                    <label for="star1">★</label>

                </div>

            </div>


            <div class="field">

                <label>Your Experience *</label>

                <textarea
                    name="review"
                    placeholder="Tell us about your trip..."
                    required
                >{{ old('review') }}</textarea>

            </div>


            <div class="field">

                <label>Upload Your Trip Photo</label>

                <input
                    type="file"
                    name="photo"
                    accept="image/jpeg,image/png,image/webp"
                >

                <small>
                    Maximum size: 2MB
                </small>

            </div>


            <button
                type="submit"
                class="submit-btn"
            >
                Submit My Review
            </button>

        </form>

        <a
            href="{{ route('home') }}"
            class="back"
        >
            ← Back to TripNest
        </a>

    </div>

</div>

</body>

</html>