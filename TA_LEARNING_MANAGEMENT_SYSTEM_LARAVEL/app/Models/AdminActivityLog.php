<?php

namespace App\Models;

use App\Models\Base\AdminActivityLog as BaseAdminActivityLog;

class AdminActivityLog extends BaseAdminActivityLog
{
	protected $fillable = [
		'admin_id',
		'action',
		'model',
		'data_id',
		'description',
		'ip_address'
	];
}
