<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::orderByDesc('created_at')->get();

        return Inertia::render('Admin/Settings/Backup', [
            'backups' => $backups,
        ]);
    }

    public function store(Request $request)
    {
        // Simple SQLite file backup to storage/app/backups
        $databasePath = database_path('database.sqlite');

        if (! file_exists($databasePath)) {
            return redirect()->route('admin.settings.backup')->with('error', 'SQLite database file not found.');
        }

        $timestamp = now()->format('Ymd_His');
        $fileName = 'backup_' . $timestamp . '_' . Str::random(6) . '.sqlite';
        $relativePath = 'backups/' . $fileName;

        Storage::disk('local')->makeDirectory('backups');

        $contents = file_get_contents($databasePath);
        Storage::disk('local')->put($relativePath, $contents);

        $size = Storage::disk('local')->size($relativePath) ?? 0;

        Backup::create([
            'name' => 'Backup ' . $timestamp,
            'disk' => 'local',
            'path' => $relativePath,
            'size' => $size,
        ]);

        return redirect()->route('admin.settings.backup')->with('success', 'Database backup created successfully.');
    }

    public function download(Backup $backup)
    {
        if (! Storage::disk($backup->disk)->exists($backup->path)) {
            return redirect()->route('admin.settings.backup')->with('error', 'Backup file not found.');
        }

        $fullPath = Storage::disk($backup->disk)->path($backup->path);
        $downloadName = Str::slug($backup->name) . '.sqlite';

        return response()->download($fullPath, $downloadName);
    }
}
