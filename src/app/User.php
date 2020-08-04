<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name', 'email', 'password', 'rolId', 'Activo', 'nopassword',
	];

	/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function roles()
	{
		return $this->belongsToMany('App\Role','role_user','user_id','role_id');
	}

	public function hasAnyRole($roles)
	{
		if(is_array($roles))
		{
			foreach ($roles as $role)
			{
				if($this->hasRole($roles))
				{
					return true;
				}
			}
		}
		else
		{
			if($this->hasRole($roles))
			{
				return true;
			}
		}
		return false;
	}

	public function hasRole($role)
	{
		$retVal = DB::select('select 1
						  from roles
						  inner join role_user on roles.id = role_user.role_id
						  where role_user.user_id = ? and roles.name = ? order by id limit 1', [$this->id , $role]);
		
		if(count($retVal))
		{
			return true;
		}
		return false;
	}

	public function hasAnyPerm($perms)
	{
		if(is_array($perms))
		{
			foreach ($perms as $perm)
			{
				if($this->hasPerm($perms))
				{
					return true;
				}
			}
		}
		else
		{
			if($this->hasPerm($perms))
			{
				return true;
			}
		}
		return false;
	}

	public function hasPerm($perm)
	{
		$retVal = DB::select('select 1
						  from role_user ru
						  inner join permission_role pr on ru.role_id = pr.role_id
						  inner join permissions pe on pr.permission_id = pe.id
						  where ru.user_id = ? and pe.name = ? order by id limit 1', [$this->id , $perm]);
		if(count($retVal))
		{
			return true;
		}
		return false;
	}
	
	public function canTakeExam($id)
	{
		$retVal = DB::select('Select id
						  From permisos 
						  where UsuarioId = ? and ExamenId = ? and Activo = 1
						  and now() between FechaDesde and FechaHasta order by id limit 1; ', [$this->id, $id]);
		if(count($retVal))
		{
			return $retVal[0]->id;
		}
		return 0;
	}
	

}
