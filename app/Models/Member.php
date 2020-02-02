<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	protected $table = 'members';
	protected $fillable = array('id', 'name', 'no_telepon','jenis_kelamin','usia','alamat');

	public $timestamps = true;

	public function borrow()
    {
        return $this->hasMany(Borrow::class, 'borrows_id');
    }
     public function profile()
    {
        return $this->hasMany(Profile::class, 'profiles_id')
    }
}