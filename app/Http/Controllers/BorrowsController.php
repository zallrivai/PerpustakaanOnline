<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleXMLElement;

class BorrowsController extends Controller
{
	public function index()
	{
		$borrows = Borrow::OrderBy('id', 'DESC')->paginate(2)->toArray();
		$response = [ 
			"total_count" => $borrows["total"],
			"limit" => $borrows["per_page"],
			"pagination" => [
				"next_page" => $borrows["next_page_url"],
				"current_page" => $borrows["current_page"]
			],
			"data" => $borrows["data"]
		];

		//$output = [
		//	'message' => 'borrows',
		//	'result' => $borrows
		//];
		return response()->json($borrows, 200);
	}
	public function store(Request $request)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();

			$validationRules = [
				'tanggal_pinjam' => 'required|min:5',
				'tanggal_kembali' => 'required|min:5',
				'jumlah_buku' => 'required|max:2',
				'user_id' => 'required|exists:users,id',
				'members_id' => 'required|exists:members,id',
				'books_id' => 'required|exists:books,id'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){
				return response()->json($validator->errors(), 400);
			}

			$borrows = Borrow::create($input);

			if($acceptHeader === 'application/json'){
				return response()->json($borrows, 200);
			}else{
				
				$xml = new SimpleXMLElement('<borrows/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('borrow');

					$xmlItem->addChild('id', $borrows->id);
					$xmlItem->addChild('tanggal_pinjam', $borrows->tanggal_pinjam);
					$xmlItem->addChild('tanggal_kembali', $borrows->tanggal_kembali);
					$xmlItem->addChild('jumlah_buku', $borrows->jumlah_buku);
					$xmlItem->addChild('user_id', $borrows->user_id);
					$xmlItem->addChild('members_id', $borrows->members_id);
					$xmlItem->addChild('books_id', $borrows->books_id);
					$xmlItem->addChild('created_at', $borrows->created_at);
					$xmlItem->addChild('updated_at', $borrows->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$input = $request->all();
		//$borrows = Borrow::create($input);

		//return response()->json($borrows, 200);
	
	public function show(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$borrows = Borrow::find($id);

			if(!$borrows) {
			abort(404);
			}

			if($acceptHeader === 'application/json'){
				return response()->json($borrows, 200);
			}else{
				
				$xml = new SimpleXMLElement('<borrows/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('borrow');

					$xmlItem->addChild('id', $borrows->id);
					$xmlItem->addChild('tanggal_pinjam', $borrows->tanggal_pinjam);
					$xmlItem->addChild('tanggal_kembali', $borrows->tanggal_kembali);
					$xmlItem->addChild('jumlah_buku', $borrows->jumlah_buku);
					$xmlItem->addChild('user_id', $borrows->user_id);
					$xmlItem->addChild('members_id', $borrows->members_id);
					$xmlItem->addChild('books_id', $borrows->books_id);
					$xmlItem->addChild('created_at', $borrows->created_at);
					$xmlItem->addChild('updated_at', $borrows->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$borrows = Borrow::find($id);

		//if(!$borrows) {
		//	abort(404);
		//}
		//return response()->json($borrows, 200);
	//}
	public function update(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');

		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();
			$borrows = Borrow::find($id);

			if(!$borrows){
			abort(404);
			}

			$validationRules = [
				'tanggal_pinjam' => 'required|min:5',
				'tanggal_kembali' => 'required|min:5',
				'jumlah_buku' => 'required|max:2',
				'user_id' => 'required|exists:users,id',
				'members_id' => 'required|exists:members,id',
				'books_id' => 'required|exists:books,id'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){
				return response()->json($validator->errors(), 400);
			}

			$borrows->fill($input);
			$borrows->save();

			if($acceptHeader === 'application/json'){
				return response()->json($borrows, 200);
			}else{
				
				$xml = new SimpleXMLElement('<borrows/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('borrow');

					$xmlItem->addChild('id', $borrows->id);
					$xmlItem->addChild('tanggal_pinjam', $borrows->tanggal_pinjam);
					$xmlItem->addChild('tanggal_kembali', $borrows->tanggal_kembali);
					$xmlItem->addChild('jumlah_buku', $borrows->jumlah_buku);
					$xmlItem->addChild('user_id', $borrows->user_id);
					$xmlItem->addChild('members_id', $borrows->members_id);
					$xmlItem->addChild('books_id', $borrows->books_id);
					$xmlItem->addChild('created_at', $borrows->created_at);
					$xmlItem->addChild('updated_at', $borrows->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$input = $request->all();
		//$borrows = Borrow::find($id);

		//if(!$borrows){
		//	abort(404);
		//}

		//$borrows->fill($input);
		//$borrows->save();

		//return response()->json($borrows, 200);
	//}
	public function destroy($id)
	{
		$borrows = Borrow::find($id);

		if(!$borrows){
			abort(404);
		}

		$borrows->delete();
		$message = ['message' => 'Delete successfully', 'borrows_id' => $id];

		return response()->json($message, 200);
	}
}
