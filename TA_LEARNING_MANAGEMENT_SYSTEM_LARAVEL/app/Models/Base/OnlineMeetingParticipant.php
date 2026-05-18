<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\OnlineMeeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OnlineMeetingParticipant
 * 
 * @property int $id
 * @property int $online_meeting_id
 * @property int $user_id
 * @property string $role
 * @property Carbon $joined_at
 * @property Carbon|null $left_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property OnlineMeeting $online_meeting
 * @property User $user
 *
 * @package App\Models\Base
 */
class OnlineMeetingParticipant extends Model
{
	protected $table = 'online_meeting_participants';

	protected $casts = [
		'online_meeting_id' => 'int',
		'user_id' => 'int',
		'joined_at' => 'datetime',
		'left_at' => 'datetime'
	];

	public function online_meeting()
	{
		return $this->belongsTo(OnlineMeeting::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
