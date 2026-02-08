<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\BlogPost;
use App\Models\User;
use App\Models\ContactMessage;
use App\Models\VehicleRequest;
use App\Models\EvaluationRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_vehicles' => Vehicle::count(),
            'active_vehicles' => Vehicle::where('is_active', true)->count(),
            'featured_vehicles' => Vehicle::where('is_featured', true)->count(),
            'total_blog_posts' => BlogPost::count(),
            'published_blog_posts' => BlogPost::where('is_published', true)->count(),
            'featured_blog_posts' => BlogPost::where('is_featured', true)->count(),
            'total_views' => BlogPost::sum('views'),
            'total_users' => User::count(),
            'total_admins' => User::where('is_admin', true)->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
            'unread_vehicle_requests' => VehicleRequest::where('is_read', false)->count(),
            'total_vehicle_requests' => VehicleRequest::count(),
            'unread_evaluation_requests' => EvaluationRequest::where('is_read', false)->count(),
            'total_evaluation_requests' => EvaluationRequest::count(),
            'recent_vehicles' => Vehicle::latest()->limit(5)->get(),
            'recent_blog_posts' => BlogPost::latest()->limit(5)->get(),
            'recent_messages' => ContactMessage::latest()->limit(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
