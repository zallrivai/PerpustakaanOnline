<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleXMLElement;

class BooksController extends Controller
{
	public function index()
	{
		$books = Book::OrderBy('id', 'DESC')->paginate(2)->toArray();
		$response = [ 
			"total_count" => $books["total"],
			"limit" => $books["per_page"],
			"pagination" => [
				"next_page" => $books["next_page_url"],
				"current_page" => $books["current_page"]
			],
			"data" => $books["data"]
		];

		//$output = [
		//	'message' => 'books',
		//	'result' => $books
		//];
		return response()->json($books, 200);
	}
	public function store(Request $request)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();

			$validationRules = [
				'name' => 'required|min:2',
				'penerbit' => 'required|min:5',
				'penulis' => 'required|min:5',
				'categories_id' => 'required|exists:categories,id',
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){	
				return response()->json($validator->errors(), 400);
			}

			$books = Book::create($input);

			if($acceptHeader === 'application/json'){
				return response()->json($books, 200);
			}else{
				
				$xml = new SimpleXMLElement('<books/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('book');

					$xmlItem->addChild('id', $books->id);
					$xmlItem->addChild('name', $books->name);
					$xmlItem->addChild('penerbit', $books->penerbit);
					$xmlItem->addChild('penulis', $books->penulis);
					$xmlItem->addChild('categories_id', $books->categories_id);
					$xmlItem->addChild('created_at', $books->created_at);
					$xmlItem->addChild('updated_at', $books->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$input = $request->all();
		//$books = Book::create($input);

		//return response()->json($books, 200);
	
	public function show(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$books = Book::find($id);

			if(!$books) {
			abort(404);
			}

			if($acceptHeader === 'application/json'){
				return response()->json($books, 200);
			}else{
				
				$xml = new SimpleXMLElement('<books/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('book');

					$xmlItem->addChild('id', $books->id);
					$xmlItem->addChild('name', $books->name);
					$xmlItem->addChild('penerbit', $books->penerbit);
					$xmlItem->addChild('penulis', $books->penulis);
					$xmlItem->addChild('categories_id', $books->categories_id);
					$xmlItem->addChild('created_at', $books->created_at);
					$xmlItem->addChild('updated_at', $books->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$books = Book::find($id);

		//if(!$books) {
		//	abort(404);
		//}
		//return response()->json($books, 200);
	
	public function update(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');

		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();
			$books = Book::find($id);

			if(!$books){
			abort(404);
			}

			$validationRules = [
				'name' => 'required|min:2',
				'penerbit' => 'required|min:5',
				'penulis' => 'required|min:5',
				'categories_id' => 'required|exists:categories,id',
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){	
				return response()->json($validator->errors(), 400);
			}
			

			$books->fill($input);
			$books->save();

			if($acceptHeader === 'application/json'){
				return response()->json($books, 200);
			}else{
				
				$xml = new SimpleXMLElement('<books/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('book');

					$xmlItem->addChild('id', $books->id);
					$xmlItem->addChild('name', $books->name);
					$xmlItem->addChild('penerbit', $books->penerbit);
					$xmlItem->addChild('penulis', $books->penulis);
					$xmlItem->addChild('categories_id', $books->categories_id);
					$xmlItem->addChild('created_at', $books->created_at);
					$xmlItem->addChild('updated_at', $books->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$input = $request->all();
		//$books = Book::find($id);

		//if(!$books){
		//	abort(404);
		//}

		//$books->fill($input);
		//$books->save();

	//	return response()->json($books, 200);
	public function destroy($id)
	{
		$books = Book::find($id);

		if(!$books){
			abort(404);
		}

		$books->delete();
		$message = ['message' => 'Delete successfully', 'books_id' => $id];

		return response()->json($message, 200);
	}
}
