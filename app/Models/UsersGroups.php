<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UsersGroups extends Model
{
	protected $fillable = [
        	"name",
        	"description"
	];

	public $timestamps = true;
	protected $table = 'users_groups';

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_usersgroups');
	}
}

