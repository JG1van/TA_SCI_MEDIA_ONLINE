<?php

namespace App\Models;

use App\Models\Base\UnansweredQuestion as BaseUnansweredQuestion;

class UnansweredQuestion extends BaseUnansweredQuestion
{
	protected $fillable = [
		'question',
		'keyword',
		'solution_text',
		'count'
	];
}
