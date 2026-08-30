@extends('admin.layout')

@section('title', 'Customer Reviews')

@section('content')

<div class="page">

    <div class="pagehead">

        <div>

            <small>TRIPNEST CONTROL CENTER</small>

            <h1>Customer Reviews</h1>

            <p>
                Review customer feedback before publishing it.
            </p>

        </div>

    </div>


    <section class="panel">

        <div class="table">

            <table>

                <thead>

                    <tr>

                        <th>Customer</th>

                        <th>Trip</th>

                        <th>Rating</th>

                        <th>Review</th>

                        <th>Photo</th>

                        <th>Status</th>

                        <th>Actions</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($reviews as $review)

                    <tr>

                        <td>

                            <b>{{ $review->name }}</b>

                            @if($review->email)

                                <small>
                                    {{ $review->email }}
                                </small>

                            @endif

                        </td>


                        <td>

                            {{ $review->package_name ?: 'General' }}

                        </td>


                        <td>

                            <span style="color:#ffb000">

                                {{ str_repeat('★', $review->rating) }}

                            </span>

                        </td>


                        <td style="max-width:300px">

                            {{ $review->review }}

                        </td>


                        <td>

                            @if($review->photo)

                                <img
                                    src="{{ asset('storage/' . $review->photo) }}"
                                    width="70"
                                    height="70"
                                    style="
                                        object-fit:cover;
                                        border-radius:8px;
                                    "
                                >

                            @else

                                —

                            @endif

                        </td>


                        <td>

                            @if($review->status === 'approved')

                                <span style="color:#078f70">
                                    Approved
                                </span>

                            @elseif($review->status === 'rejected')

                                <span style="color:#d33">
                                    Rejected
                                </span>

                            @else

                                <span style="color:#e29a00">
                                    Pending
                                </span>

                            @endif

                        </td>


                        <td>

                            @if($review->status !== 'approved')

                                <form
                                    action="{{ route('admin.reviews.approve', $review) }}"
                                    method="POST"
                                    style="display:inline"
                                >

                                    @csrf

                                    <button type="submit">
                                        Approve
                                    </button>

                                </form>

                            @endif


                            @if($review->status !== 'rejected')

                                <form
                                    action="{{ route('admin.reviews.reject', $review) }}"
                                    method="POST"
                                    style="display:inline"
                                >

                                    @csrf

                                    <button type="submit">
                                        Reject
                                    </button>

                                </form>

                            @endif


                            <form
                                action="{{ route('admin.reviews.destroy', $review) }}"
                                method="POST"
                                style="display:inline"
                                onsubmit="return confirm('Delete this review?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button type="submit">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7">

                            No customer reviews yet.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</div>

@endsection