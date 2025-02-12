<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Notifications\BookingReadyForDelivery;
use App\Notifications\ServiceBooked;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display a paginated list of bookings.
     */
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

    /**
     * Show the form for creating a new booking.
     */
    public function create(): View
    {
        $services = Service::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        return view('app.bookings.create', compact('services'));
    }

    /**
     * Store a new booking in the database.
     *
     * @return mixed|RedirectResponse
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'service_id' => $request->input('service_id'),
                'booking_date' => $request->input('booking_date'),
                'notes' => $request->input('notes'),
                'status' => 'pending',
            ]);

            $owner = User::where('role', 'owner')->first();

            DB::afterCommit(function () use ($owner, $booking) {
                if ($owner) {
                    $owner->notify(new ServiceBooked($booking));
                }
            });

            DB::commit();

            session()->flash('notification', [
                'style' => 'toast',
                'type' => 'success',
                'message' => 'Booking created successfully.',
            ]);

            return redirect()->route('app.bookings.index');
        } catch (Exception $e) {
            DB::rollBack();

            session()->flash('notification', [
                'style' => 'toast',
                'type' => 'danger',
                'message' => 'Booking failed!',
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing an existing booking.
     */
    public function edit(int $id): View
    {
        $booking = Booking::findOrFail($id);
        $services = Service::where('status', 'active')
            ->pluck('name', 'id')
            ->toArray();

        return view('app.bookings.edit', compact('booking', 'services'));
    }

    /**
     * Update the specified booking in the database.
     */
    public function update(UpdateBookingRequest $request, int $id): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($id);

            $booking->update([
                'service_id' => $request->input('service_id'),
                'booking_date' => $request->input('booking_date'),
                'notes' => $request->input('notes'),
                'status' => $request->input('status'),
            ]);

            $user = User::where('id', $booking->user_id)->first();

            DB::afterCommit(function () use ($booking, $user) {
                if ($booking->status === 'ready for delivery' && $user) {
                    $user->notify(new BookingReadyForDelivery($booking));
                }
            });

            DB::commit();

            session()->flash('notification', [
                'style' => 'toast',
                'type' => 'success',
                'message' => 'Booking updated successfully.',
            ]);

            return redirect()->route('app.bookings.index');
        } catch (Exception $e) {
            DB::rollBack();

            session()->flash('notification', [
                'style' => 'toast',
                'type' => 'danger',
                'message' => 'Booking update failed!',
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified booking from the database.
     */
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
