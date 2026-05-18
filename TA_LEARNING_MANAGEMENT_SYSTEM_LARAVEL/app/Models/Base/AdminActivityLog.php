<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminActivityLog
 * 
 * @property int $id
 * @property int|null $admin_id
 * @property string $action
 * @property string|null $model
 * @property int|null $data_id
 * @property string|null $description
 * @property string|null $ip_address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Admin|null $admin
 *
 * @package App\Models\Base
 */
class AdminActivityLog extends Model
{
	protected $table = 'admin_activity_logs';

	protected $casts = [
		'admin_id' => 'int',
		'data_id' => 'int'
	];

	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}
}
