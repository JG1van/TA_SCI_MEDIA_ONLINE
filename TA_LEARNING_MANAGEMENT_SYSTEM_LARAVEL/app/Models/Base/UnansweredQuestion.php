<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UnansweredQuestion
 * 
 * @property int $id
 * @property string $question
 * @property string $keyword
 * @property string|null $solution_text
 * @property int $count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models\Base
 */
class UnansweredQuestion extends Model
{
	protected $table = 'unanswered_questions';

	protected $casts = [
		'count' => 'int'
	];
}
