@extends('admin.layout')

@section('title', 'Travel Management')

@section('content')
<div class="page">
    <div class="pagehead">
        <div>
            <small>TRIPNEST CRM</small>
            <h1>Travel Management</h1>
            <p>Manage customer enquiries, quotations and bookings.</p>
        </div>

        <a class="btn btn-primary"
           href="{{ route('admin.travel-management.create') }}">
            + Add Travel Record
        </a>
    </div>

    @if(session('success'))
        <div class="toast">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="stats">
        <div class="panel">
            <small>Total Records</small>
            <h2>{{ $stats['enquiries'] }}</h2>
        </div>
        <div class="panel">
            <small>New Enquiries</small>
            <h2>{{ $stats['new'] }}</h2>
        </div>
        <div class="panel">
            <small>Confirmed Bookings</small>
            <h2>{{ $stats['confirmed'] }}</h2>
        </div>
        <div class="panel">
            <small>Follow-ups Due</small>
            <h2>{{ $stats['followups'] }}</h2>
        </div>
    </div>

    <section class="panel">
        <form method="GET"
              action="{{ route('admin.travel-management.index') }}"
              class="filter-form">

            <input type="search" name="search"
                   value="{{ request('search') }}"
                   placeholder="Customer, phone, enquiry or destination">

            <select name="status">
                <option value="">All statuses</option>
                @foreach([
                    'New Enquiry', 'Contacted', 'Quotation Sent',
                    'Follow-up', 'Negotiation', 'Confirmed',
                    'Cancelled', 'Lost', 'Completed'
                ] as $status)
                    <option value="{{ $status }}"
                        @selected(request('status') === $status)>
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <select name="source">
                <option value="">All sources</option>
                @foreach([
                    'Website', 'Instagram', 'Facebook', 'Google',
                    'WhatsApp', 'Phone Call', 'Referral', 'Other'
                ] as $source)
                    <option value="{{ $source }}"
                        @selected(request('source') === $source)>
                        {{ $source }}
                    </option>
                @endforeach
            </select>

            <label>
                From
                <input type="date" name="from" value="{{ request('from') }}">
            </label>

            <label>
                To
                <input type="date" name="to" value="{{ request('to') }}">
            </label>

            <button type="submit">Filter</button>
            <a href="{{ route('admin.travel-management.index') }}">Reset</a>
        </form>
    </section>

    <section class="panel">
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Enquiry / Booking</th>
                        <th>Customer</th>
                        <th>Destination</th>
                        <th>Travel Date</th>
                        <th>Travellers</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Follow-up</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>
                                <b>{{ $record->enquiry_number }}</b>
                                <small>
                                    {{ $record->booking_number ?: 'Not booked' }}
                                </small>
                            </td>

                            <td>
                                <b>{{ $record->customer_name }}</b>
                                <small>{{ $record->phone }}</small>
                                <small>{{ $record->email }}</small>
                            </td>

                            <td>
                                {{ $record->destination }}
                                <small>{{ $record->source }}</small>
                            </td>

                            <td>
                                {{ $record->travel_date?->format('d M Y') ?? '—' }}
                                <small>
                                    Return:
                                    {{ $record->return_date?->format('d M Y') ?? '—' }}
                                </small>
                            </td>

                            <td>
                                {{ $record->adults }} adults,
                                {{ $record->children }} children,
                                {{ $record->infants }} infants
                            </td>

                            <td>
                                ₹{{ number_format((float) $record->total_amount, 2) }}
                                <small>
                                    Balance: ₹{{ number_format($record->balance_amount, 2) }}
                                </small>
                            </td>

                            <td>{{ $record->status }}</td>

                            <td>
                                {{ $record->follow_up_at?->format('d M Y, h:i A') ?? '—' }}
                            </td>

                            <td>
                                <a href="{{ route('admin.travel-management.edit', $record) }}">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.travel-management.destroy', $record) }}"
                                      onsubmit="return confirm('Delete this travel record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                No travel records found.
                                Click “Add Travel Record” to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $records->links() }}
    </section>
</div>
@endsection