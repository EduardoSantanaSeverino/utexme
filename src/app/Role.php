<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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

	protected $table = "roles";

	public function users()
	{
		return $this->belongsToMany('App\User','role_user','role_id','user_id');
	}
	
	public function perms()
	{
		return $this->belongsToMany('App\Permission','permission_role','role_id','permission_id');
	}
	
}