<?php 

namespace bishopm\base\Models;

use Laratrust\LaratrustPermission;

class Permission extends LaratrustPermission
{
	protected $guarded = array('id');
}