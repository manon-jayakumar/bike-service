@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="container-xl">
        <div class="row mt-4">
            <div class="col">
                <h2 class="page-title">{{ __('Services') }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <form action="{{ route('app.services.update', $service) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="card-title">{{ __('Edit Service') }}</h4>
                                </div>

                                <div class="col-md-4 text-end">
                                    <a href="{{ route('app.services.index') }}" class="btn btn-sm btn-secondary">{{ __('Back') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label required">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Enter the name') }}" value="{{ old('name', $service->name) }}" required>

                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('Enter description') }}">{{ old('description', $service->description) }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label required">{{ __('Price') }}</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" placeholder="{{ __('Enter the price') }}" value="{{ old('price', $service->price) }}" required>

                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label required">{{ __('Status') }}</label>
                                    <select class="form-select tom-select @error('status') is-invalid @enderror" name="status" id="status">
                                        <option value="" selected disabled>{{ __('--select status--') }}</option>
                                        <option value="active" @selected(old('status', $service->status) == 'active')>Active</option>
                                        <option value="inactive" @selected(old('status', $service->status) == 'inactive')>Inactive</option>
                                    </select>

                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer card-end text-end">
                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
