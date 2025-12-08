<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $logs = ActivityLog::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        return Inertia::render('Admin/Activity/Index', [
            'logs' => $logs,
        ]);
    }
}
