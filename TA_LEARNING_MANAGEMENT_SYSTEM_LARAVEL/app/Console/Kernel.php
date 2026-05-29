<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Daftar command custom aplikasi.
     */
    protected $commands = [
        \App\Console\Commands\CheckAuthConfig::class, // <— tambahkan ini
    ];

    /**
     * Jadwal command (jika kamu ingin menjalankan otomatis).
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('serial:send-expiry-reminder')
            ->dailyAt('08:00');
        // * * * * * php /path-ke-project/artisan schedule:run >> /dev/null 2>&1

        // Reset cache lock setiap tengah malam
        $schedule->call(function () {
            \Cache::forget('expiry-reminder-lock');
        })->dailyAt('00:00');
    }

    /**
     * Daftarkan command untuk aplikasi.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
