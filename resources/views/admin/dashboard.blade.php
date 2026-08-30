@extends('admin.layout') @section('title', 'Dashboard') @section('content')<div class="page">
    <div class="pagehead">
        <div><small>TRIPNEST CONTROL CENTER</small>
            <h1>Dashboard</h1>
            <p>Manage your travel website from one place.</p>
        </div><a class="btn" href="{{ route('admin.content.create', 'packages') }}">+ Add Package</a>
    </div>
    <div class="stats">
        @foreach ($counts as $k => $v)
            <a
                href="{{ route('admin.content.index', $k) }}"><b>{{ $v }}</b><span>{{ ucwords(str_replace('_', ' ', $k)) }}</span></a>
        @endforeach
    </div>
    <section class="panel">
        <h2>Latest enquiries</h2>
        <div class="table">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Package</th>
                    <th>Date</th>
                </tr>
                @foreach ($inquiries as $i)
                    <tr>
                        <td><b>{{ $i->name }}</b><small>{{ $i->email }}</small></td>
                        <td>{{ $i->phone }}</td>
                        <td>{{ $i->package_name ?: 'Custom trip' }}</td>
                        <td>{{ $i->travel_date?->format('d M Y') ?: '—' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
</div>@endsection
