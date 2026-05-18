<?php

namespace App\Models;

use App\Models\Base\OnlineMeetingParticipant as BaseOnlineMeetingParticipant;

class OnlineMeetingParticipant extends BaseOnlineMeetingParticipant
{
	protected $fillable = [
		'online_meeting_id',
		'user_id',
		'role',
		'joined_at',
		'left_at'
	];
}
