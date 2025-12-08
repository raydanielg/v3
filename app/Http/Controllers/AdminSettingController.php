<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class AdminSettingController extends Controller
{
    public function general()
    {
        $settings = Setting::first() ?? Setting::create();

        return Inertia::render('Admin/Settings/General', [
            'settings' => $settings,
        ]);
    }

    public function updateGeneral(Request $request)
    {
        $settings = Setting::first() ?? new Setting();

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'maintenance_mode' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'notify_email_enabled' => ['boolean'],
            'notify_inapp_enabled' => ['boolean'],
        ]);

        $settings->fill($data);
        $settings->save();

        return redirect()->route('admin.settings.general')->with('success', 'Settings updated successfully');
    }

    public function smtp()
    {
        $settings = Setting::first() ?? Setting::create();

        return Inertia::render('Admin/Settings/Smtp', [
            'settings' => $settings,
        ]);
    }

    public function updateSmtp(Request $request)
    {
        $settings = Setting::first() ?? new Setting();

        $data = $request->validate([
            'smtp_host' => ['nullable', 'string', 'max:255'],
            'smtp_port' => ['nullable', 'integer'],
            'smtp_username' => ['nullable', 'string', 'max:255'],
            'smtp_password' => ['nullable', 'string', 'max:255'],
            'smtp_encryption' => ['nullable', 'string', 'max:10'],
            'smtp_from_email' => ['nullable', 'email', 'max:255'],
            'smtp_from_name' => ['nullable', 'string', 'max:255'],
        ]);

        $settings->fill($data);
        $settings->save();

        return redirect()->route('admin.settings.smtp')->with('success', 'SMTP settings updated successfully');
    }

    public function testSmtp(Request $request)
    {
        $request->validate([
            'test_email' => ['required', 'email', 'max:255'],
        ]);

        $to = $request->input('test_email');

        try {
            Mail::raw('SMTP test email from Emas system.', function ($message) use ($to) {
                $message->to($to)->subject('SMTP Test Email');
            });
        } catch (\Throwable $e) {
            return redirect()->route('admin.settings.smtp')->with('error', 'Failed to send test email: ' . $e->getMessage());
        }

        return redirect()->route('admin.settings.smtp')->with('success', 'Test email sent successfully to ' . $to);
    }

    public function security()
    {
        $settings = Setting::first() ?? Setting::create();

        $activeSessions = DB::table('sessions')->count();
        $onlineUsers = DB::table('sessions')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');
        $totalUsers = User::count();

        return Inertia::render('Admin/Settings/Security', [
            'settings' => $settings,
            'metrics' => [
                'online_users' => $onlineUsers,
                'active_sessions' => $activeSessions,
                'total_users' => $totalUsers,
            ],
        ]);
    }

    public function health()
    {
        $settings = Setting::first() ?? Setting::create();

        // Database size (SQLite file)
        $dbPath = database_path('database.sqlite');
        $dbSize = file_exists($dbPath) ? filesize($dbPath) : 0;

        // Backups total size
        $backupsSize = Backup::sum('size');

        // Monthly usage from backups (last 6 months) - portable between SQLite/MySQL
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            $monthExpression = "DATE_FORMAT(created_at, '%Y-%m')";
        } elseif ($driver === 'pgsql') {
            $monthExpression = "TO_CHAR(created_at, 'YYYY-MM')";
        } else {
            // Default to SQLite style
            $monthExpression = "strftime('%Y-%m', created_at)";
        }

        $monthlyUsage = DB::table('backups')
            ->select(DB::raw($monthExpression . ' as month'), DB::raw('SUM(size) as total_size'))
            ->groupBy('month')
            ->orderBy('month')
            ->limit(6)
            ->get();

        // Paginated backups list
        $backups = Backup::orderByDesc('created_at')->paginate(10);

        return Inertia::render('Admin/Settings/Health', [
            'settings' => $settings,
            'stats' => [
                'db_size_bytes' => $dbSize,
                'backups_size_bytes' => $backupsSize,
                'total_size_bytes' => $dbSize + $backupsSize,
                'monthly_usage' => $monthlyUsage,
            ],
            'backups' => $backups,
        ]);
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return redirect()->route('admin.settings.health')->with('success', 'System cache cleared successfully');
    }
}
