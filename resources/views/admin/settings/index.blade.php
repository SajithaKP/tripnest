@extends('admin.layout')

@section('title', 'Website Settings')

@section('content')

<div class="page">

    <div class="pagehead">

        <div>
            <small>WEBSITE SETTINGS</small>

            <h1>Website Logo</h1>

            <p>
                Manage the logo displayed on your TripNest website.
            </p>
        </div>

    </div>


    <section class="panel logo-settings">

        <h2>TripNest Logo</h2>

        <p class="settings-description">
            Upload your website logo. PNG, JPG, WEBP or SVG are supported.
        </p>


        @if($logo && $logo->value)

            <div class="current-logo">

                <small>Current Logo</small>

                <div class="logo-preview-box">

                    <img
                        src="{{ asset('storage/' . $logo->value) }}"
                        alt="TripNest Logo"
                    >

                </div>

            </div>

        @else

            <div class="no-logo">
                No logo uploaded yet.
            </div>

        @endif


        <form
            method="POST"
            action="{{ route('admin.settings.logo') }}"
            enctype="multipart/form-data"
            class="settings-form"
        >

            @csrf

            <div class="form-group">

                <label for="logo">
                    Upload New Logo
                </label>

                <input
                    type="file"
                    id="logo"
                    name="logo"
                    accept=".jpg,.jpeg,.png,.webp,.svg"
                    required
                >

                @error('logo')
                    <small class="error">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            <button type="submit" class="btn">
                Upload Logo
            </button>

        </form>

    </section>

</div>

@endsection