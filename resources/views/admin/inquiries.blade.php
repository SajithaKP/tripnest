@extends('admin.layout') @section('title', 'Inquiries') @section('content')<div class="page">
    <div class="pagehead">
        <div><small>CUSTOMER LEADS</small>
            <h1>Travel Enquiries</h1>
            <p>Every public contact form submission is stored here.</p>
        </div>
    </div>
    <section class="panel">
        <div class="table">
            <table>
                <tr>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Trip</th>
                    <th>Date</th>
                    <th>Travellers</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @foreach ($items as $i)
                    <tr>
                        <td><b>{{ $i->name }}</b><small>{{ $i->message }}</small></td>
                        <td>{{ $i->phone }}<small>{{ $i->email }}</small></td>
                        <td>{{ $i->package_name ?: 'Custom trip' }}</td>
                        <td>{{ $i->travel_date?->format('d M Y') ?: '—' }}</td>
                        <td>{{ $i->travellers ?: '—' }}</td>
                        <td>{{ $i->status }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.content.destroy', ['inquiries', $i->id]) }}">@csrf
                                @method('DELETE')<button>Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>{{ $items->links() }}
    </section>
</div>@endsection
