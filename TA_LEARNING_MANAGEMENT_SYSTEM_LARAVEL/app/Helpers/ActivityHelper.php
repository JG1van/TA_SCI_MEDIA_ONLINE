<?php

use App\Models\AdminActivityLog;

if (!function_exists('logActivity')) {
    function logActivity($action, $model = null, $dataId = null, $description = null)
    {
        if (!auth()->check())
            return; // penting biar tidak error guest

        AdminActivityLog::create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'model' => $model,
            'data_id' => $dataId,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}