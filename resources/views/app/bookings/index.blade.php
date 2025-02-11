@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="container-xl">
        <div class="row mt-4">
            <div class="col">
                <h2 class="page-title">{{ __('Bookings') }}</h2>
            </div>
        </div>
    </div>
</div>


<div class="page-body">
    <div class="container-xl">
        @if (session('notification'))
            <div class="alert alert-{{ session('notification.type') }} alert-dismissible fade show" role="alert">
                <strong>{{ ucfirst(session('notification.type')) }}:</strong> {{ session('notification.message') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Booking List') }}</h5>

                        @isUser
                            <div class="card-actions">
                                <a href="{{ route('app.bookings.create') }}" class="btn btn-sm btn-primary">{{ __('Create') }}</a>
                            </div>
                        @endisUser
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap" style="margin: 0;">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    @isOwner
                                        <th>Customer</th>
                                    @endisOwner
                                    <th>Service</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    @isOwner
                                        <th></th>
                                    @endisOwner
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr>
                                        <td><span class="text-secondary">{{ $loop->iteration }}</span></td>
                                        @isOwner
                                            <td>{{ $booking->user->name }}</td>
                                        @endisOwner
                                        <td>{{ $booking->service->name }}</td>
                                        <td>{{ $booking->service->price }}</td>
                                        <td>{{ date('d-m-Y', strtotime($booking->booking_date)) }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'ready for delivery' ? 'info' : 'success') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->created_at->diffForHumans() }}</td>
                                        @isOwner
                                            <td>
                                                <div class="btn-group w-100" role="group">
                                                    <a href="{{ route('app.bookings.edit', $booking->id) }}" class="btn">{{ __('Edit') }}</a>

                                                    <form action="{{ route('app.bookings.destroy', $booking->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endisOwner
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            <span class="text-secondary">{{ __('No bookings found!') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection