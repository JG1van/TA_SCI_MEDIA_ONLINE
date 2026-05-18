<?php

namespace App\Models;

use App\Models\Base\Post as BasePost;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends BasePost
{
	use SoftDeletes;
	protected $fillable = [
		'serial_id',
		'user_id',
		'mapel_id',
		'title',
		'description',
		'slug',
		'link',
		'attachment',
		'embed',
		'category',
		'is_task',
		'due_date'
	];
}
