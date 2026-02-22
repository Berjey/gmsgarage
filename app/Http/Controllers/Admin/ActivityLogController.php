<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Tüm aktiviteleri listele (Sadece Super Admin)
     */
    public function index(Request $request)
    {
        // Filtreleme
        $query = ActivityLog::with('user');

        // Kullanıcıya göre filtre
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Aksiyona göre filtre
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Tarih aralığı
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sayfalama
        $activities = $query->orderBy('created_at', 'desc')->paginate(30);

        // Kullanıcı listesi (filtre için)
        $users = User::whereIn('role', ['admin', 'manager', 'editor'])
            ->orderBy('name')
            ->get();

        return view('admin.activity-logs.index', compact('activities', 'users'));
    }

    /**
     * Belirli bir kullanıcının aktivitelerini göster
     */
    public function userActivities($userId)
    {
        $user = User::findOrFail($userId);
        $activities = ActivityLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('admin.activity-logs.user', compact('user', 'activities'));
    }

    /**
     * Tüm logları temizle
     */
    public function clearAll()
    {
        $deletedCount = ActivityLog::count();
        ActivityLog::truncate();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', "{$deletedCount} adet log başarıyla temizlendi!");
    }

    /**
     * 7 günden eski logları temizle
     */
    public function clearOld()
    {
        $sevenDaysAgo = now()->subDays(7);
        $deletedCount = ActivityLog::where('created_at', '<', $sevenDaysAgo)->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', "{$deletedCount} adet eski log temizlendi!");
    }

    /**
     * Belirli bir kullanıcının loglarını temizle
     */
    public function clearUser($userId)
    {
        $user = User::findOrFail($userId);
        $deletedCount = ActivityLog::where('user_id', $userId)->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', "{$user->name} kullanıcısının {$deletedCount} adet logu temizlendi!");
    }
}
