<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	protected $fillable = array('id', 'name');

	public $timestamps = true;

	public function books()
	{
		return $this->hasMany(Book::class, 'books_id');
	}
}

