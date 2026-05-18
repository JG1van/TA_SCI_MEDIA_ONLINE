<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Serial;
use Carbon\Carbon;
use App\Http\Controllers\Admin\SerialController;
use Illuminate\Support\Facades\Cache;
class SendExpiryReminder extends Command
{
    protected $signature = 'serial:send-expiry-reminder';
    protected $description = 'Kirim email notifikasi serial expired dan akan expired';

    public function handle()
    {
        try {

            if (!Cache::add('expiry-reminder-lock', true, 21600)) {
                $this->info('Reminder sudah dijalankan dalam 6 jam terakhir.');
                return;
            }

            $controller = app(\App\Http\Controllers\Admin\SerialController::class);

            $total = $controller->processExpiry('Otomatis');

            $this->info('Total serial diproses: ' . $total);

        } catch (\Exception $e) {

            \Log::error('Command Expiry Reminder Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Terjadi error: ' . $e->getMessage());
        }
    }
}