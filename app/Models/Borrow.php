<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
	protected $table = 'borrows';
	protected $fillable = array('id', 'tanggal_pinjam', 'tanggal_kembali', 'jumlah_buku', 'user_id', 'members_id', 'books_id');

	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
	public function member()
	{
		return $this->belongsTo(Member::class, 'members_id');
	}
	//public function book()
	//{
	//	return $this->belongsTo(Book::class, 'books_id');
	//}
}