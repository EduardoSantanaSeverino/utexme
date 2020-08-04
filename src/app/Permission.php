<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 
		'display_name',
		'description',
	];

	protected $table = "permissions";
	
	public function roles()
	{
		return $this->belongsToMany('App\Role','permission_role','permission_id','role_id');
	}

}
