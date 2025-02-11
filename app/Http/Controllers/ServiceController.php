<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::select('id', 'name', 'price', 'status', 'created_at')->get();

        return view('app.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('app.services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Service::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'status' => $request->input('status')
        ]);
        
        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Service created successfully.'
        ]);

        return redirect()->route('app.services.index');
    }

    public function edit($id): View
    {
        $service = Service::findOrFail($id);

        return view('app.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);

        $service->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'status' => $request->input('status')
        ]);

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Service updated successfully.'
        ]);

        return redirect()->route('app.services.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);

        $service->delete();

        session()->flash('notification', [
            'style' => 'toast',
            'type' => 'success',
            'message' => 'Service deleted successfully.'
        ]);

        return redirect()->route('app.services.index');
    }
}
