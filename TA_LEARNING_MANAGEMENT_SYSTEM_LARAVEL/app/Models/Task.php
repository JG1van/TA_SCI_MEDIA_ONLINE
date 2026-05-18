<?php

namespace App\Models;

use App\Models\Base\Task as BaseTask;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends BaseTask
{
	use SoftDeletes;
	protected $fillable = [
		'serial_id',
		'post_id',
		'student_id',
		'description',
		'attachment',
		'point'
	];
}
