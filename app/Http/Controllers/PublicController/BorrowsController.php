<?php

namespace App\Http\Controllers\PublicController;

use App\Models\Borrow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BorrowsController extends Controller
{
	public function index(Request $request)
	{
		$borrows = Borrow::with('user')->OrderBy("id", "DESC")->paginate(2)->toArray(); 
		//$members = Borrow::with('member')->OrderBy("id", "DESC")->paginate(2)->toArray();

		$response = [ 
			"total_count" => $borrows["total"],
			"limit" => $borrows["per_page"],
			"pagination" => [
				"next_page" => $borrows["next_page_url"],
				"current_page" => $borrows["current_page"]
			],
			"data" => $borrows["data"],
		//	"data" => $members["data"],
		];
		return response()->json($response, 200);
		//$borrows = Borrow::with('member')->OrderBy("id", "DESC")->paginate(10)->toArray();

		//$response = [ 
		//	"total_count" => $borrows["total"],
		//	"limit" => $borrows["per_page"],
		//	"pagination" => [
		//		"next_page" => $borrows["next_page_url"],
		//		"current_page" => $borrows["current_page"]
		//	],
		//	"data" => $borrows["data"],
		//];
		//return response()->json($response, 200);

		//$borrows = Borrow::with('books')->OrderBy("id", "DESC")->paginate(10)->toArray();

		//$response = [ 
		//	"total_count" => $borrows["total"],
		//	"limit" => $borrows["per_page"],
		//	"pagination" => [
		//		"next_page" => $borrows["next_page_url"],
		//		"current_page" => $borrows["current_page"]
		//	],
		//	"data" => $borrows["data"],
		//];
		//return response()->json($response, 200);
	}
	public function show(Request $request, $id)
	{
		$borrows = Borrow::with(['user',function($query){
			$query->select('id', 'name');
		}])->find($id);

		if(!$borrows){
			abort(404);
		}
		return response()->json($borrows, 200);

		//$borrows = Borrow::with(['member',function($query){
		//	$query->select('id', 'name');
		//}])->find($id);

		//if(!$borrows){
		//	abort(404);
		//}
		//return response()->json($borrows, 200);

		//$members = Member::with(['members' => function($query){
		//	$query->select('id', 'name');
		//}])->find($id);

		//if(!$members){
		//	abort(404);
		//}
		//return response()->json($members, 200);

		//$books = Book::with(['books' => function($query){
		//	$query->select('id', 'name');
		//}])->find($id);

		//if(!$books){
		//	abort(404);
		//}
		//return response()->json($books, 200);
	}


}