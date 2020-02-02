<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleXMLElement;

class CategoriesController extends Controller
{
	public function index(Request $request)
	{
		$categories = Category::OrderBy('id', 'DESC')->paginate(2)->toArray();

		$response = [ 
			"total_count" => $categories["total"],
			"limit" => $categories["per_page"],
			"pagination" => [
				"next_page" => $categories["next_page_url"],
				"current_page" => $categories["current_page"]
			],
			"data" => $categories["data"]
		];

		//$output = [
		//	'message' => 'categories',
		//	'result' => $categories
		//];
		return response()->json($categories, 200);
	}
	public function store(Request $request)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();

			$validationRules = [
				'name' => 'required|min:5'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){
				return response()->json($validator->errors(), 400);
			}

			$categories = Category::create($input);

			if($acceptHeader === 'application/json'){
				return response()->json($categories, 200);
			}else{
				
				$xml = new SimpleXMLElement('<categories/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('category');

					$xmlItem->addChild('id', $categories->id);
					$xmlItem->addChild('name', $categories->name);
					$xmlItem->addChild('created_at', $categories->created_at);
					$xmlItem->addChild('updated_at', $categories->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$input = $request->all();
		//$categories = Category::create($input);

		//return response()->json($categories, 200);
	
	public function show(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$categories = Category::find($id);

			if(!$categories) {
			abort(404);
			}

			if($acceptHeader === 'application/json'){
				return response()->json($categories, 200);
			}else{
				
				$xml = new SimpleXMLElement('<categories/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('category');

					$xmlItem->addChild('id', $categories->id);
					$xmlItem->addChild('name', $categories->name);
					$xmlItem->addChild('created_at', $categories->created_at);
					$xmlItem->addChild('updated_at', $categories->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$categories = Category::find($id);

		//if(!$categories) {
		//	abort(404);
		//}
		//return response()->json($categories, 200);
	
	public function update(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');

		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();
			$categories = Category::find($id);

			if(!$categories){
			abort(404);
			}

			$validationRules = [
				'name' => 'required|min:5'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){
				return response()->json($validator->errors(), 400);
			}

			$categories->fill($input);
			$categories->save();

			$contentTypeHeader = $request->header('Content-Type');

			if($acceptHeader === 'application/json'){
				if($contentTypeHeader === 'application/json'){
					return response()->json($categories, 200);
				}else{
					return response('Unsupported Media Type', 415);
				}
			}else{
				if($contentTypeHeader === 'application/xml'){
				
						$xml = new SimpleXMLElement('<categories/>');
					//foreach ($users->items('data') as $item){
						$xmlItem = $xml->addChild('category');

						$xmlItem->addChild('id', $categories->id);
						$xmlItem->addChild('name', $categories->name);
						$xmlItem->addChild('created_at', $categories->created_at);
						$xmlItem->addChild('updated_at', $categories->updated_at);
					//}
						return $xml->asXML();
				}else{
					return response('Unsupported Media Type', 415);
				}
				
				
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$input = $request->all();
		//$categories = Category::find($id);

		//if(!$categories){
		//	abort(404);
		//}

		//$categories->fill($input);
		//$categories->save();

		//return response()->json($categories, 200);
	
	public function destroy($id)
	{
		$categories = Category::find($id);

		if(!$categories){
			abort(404);
		}

		$categories->delete();
		$message = ['message' => 'Delete successfully', 'categories_id' => $id];

		return response()->json($message, 200);
	}
}
