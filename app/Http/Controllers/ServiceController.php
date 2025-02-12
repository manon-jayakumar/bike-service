<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a paginated list of services.
     */
    public function index(): View
    {
        $services = Service::select('id', 'name', 'price', 'status', 'created_at')
            ->latest()
            ->paginate(10);

        return view('app.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): View
    {
        return view('app.services.create');
    }

    /**
     * Store a newly created service in the database.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Service::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
        ]);

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Service created successfully.',
        ]);

        return redirect()->route('app.services.index');
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param  int  $id
     */
    public function edit($id): View
    {
        $service = Service::findOrFail($id);

        return view('app.services.edit', compact('service'));
    }

    /**
     * Update the specified service in the database.
     */
    public function update(UpdateServiceRequest $request, int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);

        $service->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'status' => $request->input('status'),
        ]);

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Service updated successfully.',
        ]);

        return redirect()->route('app.services.index');
    }

    /**
     * Remove the specified service from the database.
     */
    public function destroy(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);

        $service->delete();

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Service deleted successfully.',
        ]);

        return redirect()->route('app.services.index');
    }
}
