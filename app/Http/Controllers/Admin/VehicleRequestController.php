<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;

class VehicleRequestController extends Controller
{
    /**
     * Display a listing of vehicle requests
     */
    public function index()
    {
        $requests = VehicleRequest::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.vehicle-requests.index', compact('requests'));
    }

    /**
     * Display a specific vehicle request
     */
    public function show($id)
    {
        $request = VehicleRequest::findOrFail($id);
        if (!$request->is_read) {
            $request->markAsRead();
        }
        return view('admin.vehicle-requests.show', compact('request'));
    }

    /**
     * Mark request as read
     */
    public function markAsRead($id)
    {
        $request = VehicleRequest::findOrFail($id);
        $request->markAsRead();
        return back()->with('success', 'İstek okundu olarak işaretlendi.');
    }

    /**
     * Delete a vehicle request
     */
    public function destroy($id)
    {
        $request = VehicleRequest::findOrFail($id);
        $request->delete();
        return redirect()->route('admin.vehicle-requests.index')
            ->with('success', 'İstek başarıyla silindi.');
    }
}
