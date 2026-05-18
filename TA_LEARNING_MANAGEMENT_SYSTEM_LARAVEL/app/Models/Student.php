<?php

namespace App\Models;

use App\Models\Base\Student as BaseStudent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Student extends BaseStudent implements AuthenticatableContract
{
	use Authenticatable, SoftDeletes;
	public $role = 'siswa';

	protected $hidden = [
		'password'
	];

	protected $fillable = [

		'serial_id',
		'user_id',
		'classroom_id',
		'name',
		'username',
		'password',
		'nis',

		'absen_number',

		'email',
		'phone',

		'photo',

	];
}
