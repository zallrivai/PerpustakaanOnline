<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;

class MembersController extends Controller
{
	public function index()
	{

		$members = Member::OrderBy('id', 'DESC')->paginate(2)->toArray();//Where(['members_id' => Auth::user()->id])->OrderBy('id', 'DESC')->paginate(2)->toArray();

		$response = [ 
			"total_count" => $members["total"],
			"limit" => $members["per_page"],
			"pagination" => [
				"next_page" => $members["next_page_url"],
				"current_page" => $members["current_page"]
			],
			"data" => $members["data"]
		];

		//$output = [
		//	'message' => 'members',
		//	'result' => $members
		//];
		return response()->json($members, 200);
	}
	public function store(Request $request)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();

			$validationRules = [
				'name' => 'required|min:2',
				'no_telepon' => 'required|min:5',
				'jenis_kelamin' => 'required|min:5',
				'usia' => 'required|max:2',
				'alamat' => 'required|min:5'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){	
				return response()->json($validator->errors(), 400);
			}

			$members = Member::create($input);

			if($acceptHeader === 'application/json'){
				return response()->json($members, 200);
			}else{
				
				$xml = new SimpleXMLElement('<members/>');
				foreach ($members->items('data') as $item){
					$xmlItem = $xml->addChild('member');

					$xmlItem->addChild('id', $item->id);
					$xmlItem->addChild('name', $item->name);
					$xmlItem->addChild('no_telepon', $item->no_telepon);
					$xmlItem->addChild('jenis_kelamin', $item->jenis_kelamin);
					$xmlItem->addChild('usia', $item->usia);
					$xmlItem->addChild('alamat', $item->alamat);
					$xmlItem->addChild('created_at', $item->created_at);
					$xmlItem->addChild('updated_at', $item->updated_at);
				}

				return $xml->asXML();
			}
		}else{
			return response('Not Acceptable !', 406);
		}	
	}
	public function show(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');
		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$members = Member::find($id);

			if(!$members) {
			abort(404);
			}

			$validationRules = [
				'name' => 'required|min:2',
				'no_telepon' => 'required|min:5',
				'jenis_kelamin' => 'required|min:5',
				'usia' => 'required|max:2',
				'alamat' => 'required|min:5'
			];

			$validator = \Validator::make($input, $validationRules);
			if($validator->fails()){	
				return response()->json($validator->errors(), 400);
			}


			if($acceptHeader === 'application/json'){
				return response()->json($members, 200);
			}else {
				$xml = new SimpleXMLElement('<members/>');
				foreach ($members->items('data') as $item){
					$xmlItem = $xml->addChild('member');

					$xmlItem->addChild('id', $item->id);
					$xmlItem->addChild('name', $item->name);
					$xmlItem->addChild('no_telepon', $item->no_telepon);
					$xmlItem->addChild('jenis_kelamin', $item->jenis_kelamin);
					$xmlItem->addChild('usia', $item->usia);
					$xmlItem->addChild('alamat', $item->alamat);
					$xmlItem->addChild('created_at', $item->created_at);
					$xmlItem->addChild('updated_at', $item->updated_at);

					return $xml->asXML();
				}

			}
			
		}else{
				return response('Not Acceptable !', 406);
			}
	}
	public function update(Request $request, $id)
	{
		$acceptHeader = $request->header('Accept');

		if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
			$input = $request->all();
			$members = Member::find($id);

			if(!$members){
			abort(404);
			}

			$members->fill($input);
			$members->save();

			if($acceptHeader === 'application/json'){
				return response()->json($members, 200);
			}else{
				$xml = new SimpleXMLElement('<members/>');
				foreach ($members->items('data') as $item){
					$xmlItem = $xml->addChild('member');

					$xmlItem->addChild('id', $item->id);
					$xmlItem->addChild('name', $item->name);
					$xmlItem->addChild('no_telepon', $item->no_telepon);
					$xmlItem->addChild('jenis_kelamin', $item->jenis_kelamin);
					$xmlItem->addChild('usia', $item->usia);
					$xmlItem->addChild('alamat', $item->alamat);
					$xmlItem->addChild('created_at', $item->created_at);
					$xmlItem->addChild('updated_at', $item->updated_at);

					return $xml->asXML();
				}

			}
		}else{
			return response('Not Acceptable !', 406);
		}		
	}
	public function destroy($id)
	{
		$members = Member::find($id);

		if(!$members){
			abort(404);
		}

		$members->delete();
		$message = ['message' => 'Delete successfully', 'members_id' => $id];

		return response()->json($message, 200);
	}
}