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
                        <h5 class="card-title">{{ __('Service List') }}</h5>

                        <div class="card-actions">
                            <a href="{{ route('app.services.create') }}" class="btn btn-sm btn-primary">{{ __('Create') }}</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap" style="margin: 0;">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Service</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td><span class="text-secondary">{{ $loop->iteration }}</span></td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->price }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $service->status == 'active' ? 'success' : 'warning' }}">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $service->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="btn-group w-100" role="group">
                                                <a href="{{ route('app.services.edit', $service->id) }}" class="btn">{{ __('Edit') }}</a>

                                                <form action="{{ route('app.services.destroy', $service->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">
                                            <span class="text-secondary">{{ __('No services found!') }}</span>
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