<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role === 'owner') {
            $pendingCount = Booking::where('status', 'pending')->count();
            $readyForDeliveryCount = Booking::where('status', 'ready for delivery')->count();
            $completedCount = Booking::where('status', 'completed')->count();
        } else {
            $pendingCount = Booking::where('status', 'pending')
                ->where('user_id', auth()->id())
                ->count();
            $readyForDeliveryCount = Booking::where('status', 'ready for delivery')
                ->where('user_id', auth()->id())
                ->count();
            $completedCount = Booking::where('status', 'completed')
                ->where('user_id', auth()->id())
                ->count();
        }

        return view('home', compact('pendingCount', 'readyForDeliveryCount', 'completedCount'));
    }
}
