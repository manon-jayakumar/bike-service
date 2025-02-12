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
                    <form action="{{ route('app.bookings.store') }}" method="POST">
                        @csrf

                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="card-title">{{ __('Create Booking') }}</h4>
                                </div>

                                <div class="col-md-4 text-end">
                                    <a href="{{ route('app.bookings.index') }}" class="btn btn-sm btn-secondary">{{ __('Back') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-6 mb-3">
                                    <label for="service_id" class="form-label required">{{ __('Service') }}</label>
                                    <select class="form-select tom-select @error('service_id') is-invalid @enderror" name="service_id" id="service_id">
                                        <option value="" selected disabled>{{ __('--select service--') }}</option>

                                        @foreach ($services as $id => $name)
                                            <option value="{{ $id }}" @selected(old('service_id') == $id)>{{ $name }}</option>
                                        @endforeach
                                    </select>

                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </label>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="booking_date" class="form-label required">{{ __('Date') }}</label>
                                    <input type="date" name="booking_date" id="booking_date" class="form-control @error('booking_date') is-invalid @enderror" value="{{ old('booking_date') }}" required>

                                    @error('booking_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                                    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control @error('notes') is-invalid @enderror" placeholder="{{ __('Enter notes') }}">{{ old('notes') }}</textarea>

                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer card-end text-end">
                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
