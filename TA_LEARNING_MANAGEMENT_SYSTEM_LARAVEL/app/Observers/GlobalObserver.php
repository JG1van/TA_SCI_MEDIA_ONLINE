<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminActivityLog;

class GlobalObserver
{
    protected array $globalExcept = [
        'updated_at',
        'created_at',
        'remember_token',
        'login_at',
        'password',
        'img',
        'photo',
        'deleted_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Mapping field _id ke Model dan field label-nya
     * Format: 'nama_field' => [ModelClass::class, 'field_label']
     */
    protected array $idFieldMap = [
        // Admins
        'admin_id' => [\App\Models\Admin::class, 'name'],

        // Users
        'user_id' => [\App\Models\User::class, 'name'],

        // Students
        'student_id' => [\App\Models\Student::class, 'name'],

        // Lessons & Mapel
        'lesson_id' => [\App\Models\Lesson::class, 'name'],
        'mapel_id' => [\App\Models\Mapel::class, 'name'],

        // Themes & Subthemes
        'theme_id' => [\App\Models\Theme::class, 'name'],
        'subtheme_id' => [\App\Models\Subtheme::class, 'name'],

        // Products & Serials
        'product_id' => [\App\Models\Product::class, 'name'],
        'serial_id' => [\App\Models\Serial::class, 'serial'],

        // Classrooms
        'classroom_id' => [\App\Models\Classroom::class, 'name'],

        // Exercises
        'exercise_id' => [\App\Models\Exercise::class, 'title'],
        'exercise_type_id' => [\App\Models\ExerciseType::class, 'name'],
        'exercise_model_id' => [\App\Models\ExerciseModel::class, 'name'],

        // Competences
        'competence_id' => [\App\Models\Competence::class, 'point'],

        // Customer Service
        'room_id' => [\App\Models\CsRoom::class, 'room_code'],
        'question_categories_id' => [\App\Models\QuestionCategory::class, 'name'],
    ];

    // -------------------------------------------------------

    public function created(Model $model)
    {
        if ($model instanceof AdminActivityLog)
            return;

        logActivity(
            'CREATE',
            class_basename($model),
            $model->id,
            $this->buildDescription($model, 'created')
        );
    }

    public function updated(Model $model)
    {
        if ($model instanceof AdminActivityLog)
            return;

        $description = $this->buildDescription($model, 'updated');

        if (empty($description))
            return; // skip jika tidak ada perubahan berarti

        logActivity(
            'UPDATE',
            class_basename($model),
            $model->id,
            $description
        );
    }

    public function deleted(Model $model)
    {
        if ($model instanceof AdminActivityLog)
            return;

        logActivity(
            'DELETE',
            class_basename($model),
            $model->id,
            $this->buildDescription($model, 'deleted')
        );
    }

    // -------------------------------------------------------

    protected function buildDescription(Model $model, string $event): string
    {
        $hidden = $model->getHidden();
        $except = array_merge($this->globalExcept, $hidden);
        $name = class_basename($model);
        $label = $this->getLabel($model);
        $request = request();
        $url = $request->fullUrl();
        $method = $request->method();
        $agent = $this->parseAgent($request->userAgent());

        if ($event === 'created') {
            $attributes = collect($model->getAttributes())
                ->except(array_merge($except, ['id']))
                ->map(fn($val) => $this->castValue($val))
                ->toArray();

            $detail = collect($attributes)
                ->map(fn($val, $key) => "{$key}: \"{$this->formatValue($key, $val)}\"")
                ->join(', ');

            return "Menambahkan data {$name} baru — {$label}. Detail: {$detail}. Melalui {$method} {$url} menggunakan {$agent}.";
        }

        if ($event === 'updated') {
            $changes = collect($model->getChanges())
                ->except($except)
                ->map(fn($val) => $this->castValue($val))
                ->toArray();

            if (empty($changes))
                return '';

            $detail = collect($changes)
                ->map(function ($newVal, $field) use ($model) {
                    $oldVal = $this->castValue($model->getOriginal($field));
                    $oldStr = $this->formatValue($field, $oldVal);
                    $newStr = $this->formatValue($field, $newVal);
                    return "{$field} dari \"{$oldStr}\" menjadi \"{$newStr}\"";
                })
                ->join(', ');

            return "Mengubah data {$name} — {$label}. Perubahan: {$detail}. Melalui {$method} {$url} menggunakan {$agent}.";
        }

        if ($event === 'deleted') {
            $attributes = collect($model->getAttributes())
                ->except(array_merge($except, ['id']))
                ->map(fn($val) => $this->castValue($val))
                ->toArray();

            $detail = collect($attributes)
                ->map(fn($val, $key) => "{$key}: \"{$this->formatValue($key, $val)}\"")
                ->join(', ');

            return "Menghapus data {$name} — {$label}. Data terhapus: {$detail}. Melalui {$method} {$url} menggunakan {$agent}.";
        }

        return '';
    }

    // -------------------------------------------------------

    /**
     * Format nilai field:
     * - Jika field ada di idFieldMap → resolve ke nama dari DB
     * - Jika field berakhiran _id tapi tidak di map → pakai prefix id#
     * - Selainnya → nilai apa adanya
     */
    protected function formatValue(string $field, mixed $val): string
    {
        if (is_null($val))
            return '-';

        // Field ada di idFieldMap → resolve nama dari DB
        if (array_key_exists($field, $this->idFieldMap)) {
            [$modelClass, $labelField] = $this->idFieldMap[$field];

            if (is_array($val)) {
                $names = $modelClass::whereIn('id', $val)->pluck($labelField)->toArray();
                return implode(', ', $names) ?: implode(', ', array_map(fn($v) => "id#{$v}", $val));
            }

            $record = $modelClass::find($val);
            return $record ? $record->{$labelField} : "id#{$val}";
        }

        // Field _id tapi tidak di map → pakai prefix id#
        if (str_ends_with($field, '_id')) {
            if (is_array($val)) {
                return implode(', ', array_map(fn($v) => "id#{$v}", $val));
            }
            return "id#{$val}";
        }

        // Field biasa
        if (is_array($val)) {
            return implode(', ', $val);
        }

        return (string) $val;
    }

    /**
     * Ambil field paling representatif sebagai label
     */
    protected function getLabel(Model $model): string
    {
        foreach (['name', 'title', 'email', 'username', 'code', 'serial', 'slug'] as $field) {
            if (!empty($model->{$field})) {
                return $model->{$field};
            }
        }
        return 'ID #' . $model->id;
    }

    /**
     * Decode nilai JSON string menjadi array/tipe aslinya
     */
    protected function castValue(mixed $val): mixed
    {
        if (!is_string($val))
            return $val;

        $decoded = json_decode($val, true);
        if (json_last_error() === JSON_ERROR_NONE)
            return $decoded;

        return $val;
    }

    /**
     * Parse user agent menjadi ringkasan browser/OS
     */
    protected function parseAgent(?string $agent): string
    {
        if (!$agent)
            return 'Unknown';

        $browser = match (true) {
            str_contains($agent, 'Edg') => 'Edge',
            str_contains($agent, 'Chrome') => 'Chrome',
            str_contains($agent, 'Firefox') => 'Firefox',
            str_contains($agent, 'Safari') => 'Safari',
            default => 'Browser lain',
        };

        $os = match (true) {
            str_contains($agent, 'Windows') => 'Windows',
            str_contains($agent, 'Mac') => 'Mac',
            str_contains($agent, 'Linux') => 'Linux',
            str_contains($agent, 'Android') => 'Android',
            str_contains($agent, 'iPhone') => 'iOS',
            default => 'OS lain',
        };

        return "{$browser}/{$os}";
    }
}