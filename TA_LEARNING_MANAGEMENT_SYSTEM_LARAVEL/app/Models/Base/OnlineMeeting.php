<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Classroom;
use App\Models\OnlineMeetingParticipant;
use App\Models\Serial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OnlineMeeting
 * 
 * @property int $id
 * @property int $serial_id
 * @property int $user_id
 * @property int $classroom_id
 * @property string $title
 * @property string|null $description
 * @property string $meeting_code
 * @property string $meeting_link
 * @property string|null $platform
 * @property Carbon $start_time
 * @property Carbon|null $end_time
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Classroom $classroom
 * @property Serial $serial
 * @property User $user
 * @property Collection|OnlineMeetingParticipant[] $online_meeting_participants
 *
 * @package App\Models\Base
 */
class OnlineMeeting extends Model
{
	protected $table = 'online_meetings';

	protected $casts = [
		'serial_id' => 'int',
		'user_id' => 'int',
		'classroom_id' => 'int',
		'start_time' => 'datetime',
		'end_time' => 'datetime'
	];

	public function classroom()
	{
		return $this->belongsTo(Classroom::class);
	}

	public function serial()
	{
		return $this->belongsTo(Serial::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function online_meeting_participants()
	{
		return $this->hasMany(OnlineMeetingParticipant::class);
	}
}
