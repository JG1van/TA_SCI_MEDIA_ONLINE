<?php

namespace App\Models;

use App\Models\Base\Exercise as BaseExercise;
use Illuminate\Database\Eloquent\SoftDeletes;
class Exercise extends BaseExercise
{
	use SoftDeletes;
	protected $fillable = [

		'lesson_id',
		'serial_id',
		'exercise_type_id',
		'title',
		'time_limit',
		'is_admin'
	];
}
