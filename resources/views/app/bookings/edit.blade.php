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
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <form action="{{ route('app.bookings.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <h3 class="card-title">{{ __('Edit Booking') }}</h3>

                            <div class="card-actions">
                                <a href="{{ route('app.bookings.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-6 mb-3">
                                    <label for="service_id" class="form-label required">{{ __('Service') }}</label>
                                    <select class="form-select tom-select @error('service_id') is-invalid @enderror" name="service_id" id="service_id">
                                        <option value="" selected disabled>{{ __('--select service--') }}</option>

                                        @foreach ($services as $id => $name)
                                            <option value="{{ $id }}" @selected(old('service_id', $booking->service_id) == $id)>{{ $name }}</option>
                                        @endforeach
                                    </select>

                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </label>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="booking_date" class="form-label required">{{ __('Date') }}</label>
                                    <input type="date" name="booking_date" id="booking_date" class="form-control @error('booking_date') is-invalid @enderror" value="{{ old('booking_date', $booking->booking_date) }}" required>

                                    @error('booking_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                                    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control @error('notes') is-invalid @enderror" placeholder="{{ __('Enter notes') }}">{{ old('notes', $booking->notes) }}</textarea>

                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label required">{{ __('Status') }}</label>
                                    <select class="form-select tom-select @error('status') is-invalid @enderror" name="status" id="status">
                                        <option value="" selected disabled>{{ __('--select status--') }}</option>
                                        <option value="pending" @selected(old('status', $booking->status) == 'pending')>Pending</option>
                                        <option value="ready for delivery" @selected(old('status', $booking->status) == 'ready for delivery')>Ready for delivery</option>
                                        <option value="completed" @selected(old('status', $booking->status) == 'completed')>Completed</option>
                                    </select>

                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer card-end">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
