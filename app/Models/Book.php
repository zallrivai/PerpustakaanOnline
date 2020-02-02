<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $table = 'books';
	protected $fillable = array('id', 'name', 'penerbit', 'penulis', 'categories_id');

	public $timestamps = true;

	public function category()
	{
		return $this->belongsTo(Category::class, 'categories_id');
	}
	//public function borrow()
    //{
     //   return $this->hasMany(Borrow::class,'borrow_id');
    //}
}

