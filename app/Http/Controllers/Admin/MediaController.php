<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display media library
     */
    public function index()
    {
        $files = Storage::disk('public')->files('uploads');
        $files = array_map(function($file) {
            return [
                'path' => $file,
                'url' => Storage::url($file),
                'name' => basename($file),
                'size' => Storage::disk('public')->size($file),
                'mime' => Storage::disk('public')->mimeType($file),
            ];
        }, $files);

        return view('admin.media.index', compact('files'));
    }

    /**
     * Upload file
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $filename = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
            'path' => $path,
        ]);
    }

    /**
     * Delete file
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        if (Storage::disk('public')->exists($request->path)) {
            Storage::disk('public')->delete($request->path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 404);
    }
}
