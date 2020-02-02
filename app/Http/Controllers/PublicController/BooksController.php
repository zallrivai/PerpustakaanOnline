<?php

namespace App\Http\Controllers\PublicController;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BooksController extends Controller
{
	public function index(Request $request)
	{
		$books = Book::with('category')->OrderBy("id", "DESC")->paginate(2)->toArray();

		$response = [ 
			"total_count" => $books["total"],
			"limit" => $books["per_page"],
			"pagination" => [
				"next_page" => $books["next_page_url"],
				"current_page" => $books["current_page"]
			],
			"data" => $books["data"],
		];
		return response()->json($response, 200);
	}

	public function show($id)
	{
		$books = Book::with(['category' => function($query){
			$query->select('id', 'name');
		}])->find($id);

		if(!$books){
			abort(404);
		}
		return response()->json($books, 200);
	}
}