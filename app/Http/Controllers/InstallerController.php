<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class InstallerController extends Controller
{
    public function run(Request $request)
    {
        $secret = env('INSTALL_SECRET');
        if (!$secret || $request->query('secret') !== $secret) {
            abort(403);
        }

        $lock = storage_path('app/install.lock');
        if (File::exists($lock)) {
            return response('Installer already ran.', 200);
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
            try {
                Artisan::call('storage:link');
            } catch (\Throwable $e) {
                $from = storage_path('app/public');
                $to = public_path('storage');
                if (!File::exists($to)) {
                    File::copyDirectory($from, $to);
                }
            }
            File::put($lock, now()->toDateTimeString());
            return response('Install complete', 200);
        } catch (\Throwable $e) {
            return response('Install failed: ' . $e->getMessage(), 500);
        }
    }
}
