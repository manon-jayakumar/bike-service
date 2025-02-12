@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                {{-- Pending Bookings Card --}}
                <div class="col-md-4">
                    <div class="card text-white bg-warning">
                        <div class="card-header">Pending Bookings</div>

                        <div class="card-body">
                            <h3 class="card-title">{{ $pendingCount }}</h3>
                        </div>
                    </div>
                </div>

                @isOwner
                    {{-- Ready for Delivery Bookings Card --}}
                    <div class="col-md-4">
                        <div class="card text-white bg-info">
                            <div class="card-header">Ready for Delivery Bookings</div>

                            <div class="card-body">
                                <h3 class="card-title">{{ $readyForDeliveryCount }}</h3>
                            </div>
                        </div>
                    </div>
                @endisOwner

                {{-- Completed Bookings Card --}}
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-header">Completed Bookings</div>

                        <div class="card-body">
                            <h3 class="card-title">{{ $completedCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
