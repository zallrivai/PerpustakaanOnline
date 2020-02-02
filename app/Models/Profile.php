<?php

namespace  App\Models;

use illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $fillable = array('members_id', 'first_name', 'last_name', 'summary', 'image');

	public $timestamps = true; 

	public function  members()
	{
		return $this->belongsTo(Member::class, 'members_id');
	}
}