<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Display a specific contact message
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        if (!$message->is_read) {
            $message->markAsRead();
        }
        return view('admin.contact-messages.show', compact('message'));
    }

    /**
     * Mark message as read
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();
        return back()->with('success', 'Mesaj okundu olarak işaretlendi.');
    }

    /**
     * Delete a contact message
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Mesaj başarıyla silindi.');
    }

    /**
     * Delete all contact messages
     */
    public function destroyAll()
    {
        $count = ContactMessage::count();
        ContactMessage::truncate();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', "Tüm mesajlar başarıyla silindi. ({$count} mesaj silindi)");
    }
}
