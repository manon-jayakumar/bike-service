<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Notifications\BookingReadyForDelivery;
use App\Notifications\ServiceBooked;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        if (auth()->user()->role === 'owner') {
            $bookings = Booking::with('service')
                ->select('id', 'user_id', 'service_id', 'booking_date', 'status', 'created_at')
                ->latest()
                ->paginate(10);
        } else {
            $bookings = Booking::with('service')
                ->select('id', 'user_id', 'service_id', 'booking_date', 'status', 'created_at')
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10);
        }

        return view('app.bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $services = Service::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        return view('app.bookings.create', compact('services'));
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_id' => $request->input('service_id'),
            'booking_date' => $request->input('booking_date'),
            'notes' => $request->input('notes'),
            'status' => 'pending',
        ]);

        $owner = User::where('role', 'owner')->first();

        if ($booking && $owner) {
            $owner->notify(new ServiceBooked($booking));
        }

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Booking created successfully.',
        ]);

        return redirect()->route('app.bookings.index');
    }

    public function edit(int $id): View
    {
        $booking = Booking::findOrFail($id);
        $services = Service::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        return view('app.bookings.edit', compact('booking', 'services'));
    }

    public function update(UpdateBookingRequest $request, int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'service_id' => $request->input('service_id'),
            'booking_date' => $request->input('booking_date'),
            'notes' => $request->input('notes'),
            'status' => $request->input('status'),
        ]);

        $user = User::where('id', $booking->user_id)->first();

        if ($booking && $booking->status === 'ready for delivery' && $user) {
            $user->notify(new BookingReadyForDelivery($booking));
        }

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Booking updated successfully.',
        ]);

        return redirect()->route('app.bookings.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        $booking->delete();

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Booking deleted successfully.',
        ]);

        return redirect()->route('app.bookings.index');
    }
}
