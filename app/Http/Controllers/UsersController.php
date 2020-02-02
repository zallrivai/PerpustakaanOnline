<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleXMLElement;

class UsersController extends Controller
{
	public function index()
	{
		$users = User::OrderBy('id', 'DESC')->paginate(2)->toArray();

		$response = [ 
			"total_count" => $users["total"],
			"limit" => $users["per_page"],
			"pagination" => [
				"next_page" => $users["next_page_url"],
				"current_page" => $users["current_page"]
			],
			"data" => $users["data"]
		];

		//$output = [
		//	'message' => 'users',
		//	'result' => $users
		//];
		return response()->json($users, 200);
	}
	public function store(Request $request)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();

			$validationRules = [
				'name' => 'required|min:2',
				'email' => 'required|min:8',
				'password' => 'required|min:3'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){	
				return response()->json($validator->errors(), 400);
			}

			$users = User::create($input);

			if($acceptHeader === 'application/json'){
				return response()->json($users, 200);
			}else{
				
				$xml = new SimpleXMLElement('<users/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('user');

					$xmlItem->addChild('id', $users->id);
					$xmlItem->addChild('name', $users->name);
					$xmlItem->addChild('email', $users->email);
					$xmlItem->addChild('password', $users->password);
					$xmlItem->addChild('created_at', $users->created_at);
					$xmlItem->addChild('updated_at', $users->updated_at);
				//}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
		//$input = $request->all();
		//$users = User::create($input);

		//return response()->json($users, 200);
	
	public function show(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$users = User::find($id);

			if(!$users) {
			abort(404);
			}

			if($acceptHeader === 'application/json'){
				return response()->json($users, 200);
			}else {
				$xml = new SimpleXMLElement('<users/>');
				//foreach ($users->items('data') as $item){
					$xmlItem = $xml->addChild('user');

					$xmlItem->addChild('id', $users->id);
					$xmlItem->addChild('name', $users->name);
					$xmlItem->addChild('email', $users->email);
					$xmlItem->addChild('password', $users->password);
					$xmlItem->addChild('created_at', $users->created_at);
					$xmlItem->addChild('updated_at', $users->updated_at);

					return $xml->asXML();
				//}

			}
			
		}else{
				return response('Not Acceptable !', 406);
			}
	}
		//$users = User::find($id);

		//if(!$users) {
		//	abort(404);
		//}
		//return response()->json($users, 200);
	
	public function update(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');

		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();
			$users = User::find($id);

			if(!$users){
			abort(404);
			}

			$validationRules = [
				'name' => 'required|min:2',
				'email' => 'required|min:8',
				'password' => 'required|min:3'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){	
				return response()->json($validator->errors(), 400);
			}


			$users->fill($input);
			$users->save();

			if($acceptHeader === 'application/json'){
				return response()->json($users, 200);
			}else{
				$xml = new SimpleXMLElement('<users/>');
				//foreach ($members->items('data') as $item){
					$xmlItem = $xml->addChild('user');

					$xmlItem->addChild('id', $users->id);
					$xmlItem->addChild('name', $users->name);
					$xmlItem->addChild('email', $users->email);
					$xmlItem->addChild('password', $users->password);
					$xmlItem->addChild('created_at', $users->created_at);
					$xmlItem->addChild('updated_at', $users->updated_at);

					return $xml->asXML();
				//}

			}
		}else{
			return response('Not Acceptable !', 406);
		}		
	}
		//$input = $request->all();
		//$users = User::find($id);

		//if(!$users){
		//	abort(404);
		//}

		//$users->fill($input);
		//$users->save();

		//return response()->json($users, 200);
	
	public function destroy($id)
	{
		$users = User::find($id);

		if(!$users){
			abort(404);
		}

		$users->delete();
		$message = ['message' => 'Delete successfully', 'users_id' => $id];

		return response()->json($message, 200);
	}
}
