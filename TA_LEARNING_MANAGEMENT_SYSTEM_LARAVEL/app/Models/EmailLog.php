<?php

namespace App\Models;

use App\Models\Base\EmailLog as BaseEmailLog;

class EmailLog extends BaseEmailLog
{
	protected $fillable = [
		'serial_id',
		'email_to',
		'subject',
		'email_type',
		'status',
		'source'
	];
}
