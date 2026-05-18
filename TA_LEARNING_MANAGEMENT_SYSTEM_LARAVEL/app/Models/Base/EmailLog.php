<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Serial;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailLog
 * 
 * @property int $id
 * @property int $serial_id
 * @property string $email_to
 * @property string $subject
 * @property string $email_type
 * @property string $status
 * @property string $source
 * @property Carbon $created_at
 * 
 * @property Serial $serial
 *
 * @package App\Models\Base
 */
class EmailLog extends Model
{
	protected $table = 'email_logs';
	public $timestamps = false;

	protected $casts = [
		'serial_id' => 'int'
	];

	public function serial()
	{
		return $this->belongsTo(Serial::class);
	}
}
