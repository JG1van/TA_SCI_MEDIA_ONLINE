<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminActivityLog;
class GlobalObserver
{
    public function created(Model $model)
    {
        if ($model instanceof AdminActivityLog)
            return;

        logActivity('CREATE', class_basename($model), $model->id, 'Data ditambahkan');
    }

    public function updated(Model $model)
    {
        if ($model instanceof AdminActivityLog)
            return;

        logActivity('UPDATE', class_basename($model), $model->id, 'Data diubah');
    }

    public function deleted(Model $model)
    {
        if ($model instanceof AdminActivityLog)
            return;

        logActivity('DELETE', class_basename($model), $model->id, 'Data dihapus');
    }
}
