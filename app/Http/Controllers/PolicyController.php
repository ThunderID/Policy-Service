<?php

namespace App\Http\Controllers;

use App\Libraries\JSend;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Entities\Policy;

/**
 * Policy  resource representation.
 *
 * @Resource("Policy", uri="/policies")
 */
class PolicyController extends Controller
{
	public function __construct(Request $request)
	{
		$this->request 				= $request;
	}

	/**
	 * Show all policies
	 *
	 * @Get("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"search":{"_id":"string","title":"string","slug":"string","owner":"string"},"sort":{"newest":"asc|desc","title":"desc|asc"}, "take":"integer", "skip":"integer"}),
	 *      @Response(200, body={"status": "success", "data": {"data":{"_id":"string","title":"string","slug":"string","contents":{"key":"string","value":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}},"count":"integer"} })
	 * })
	 */
	public function index()
	{
		$result						= new Policy;

		if(Input::has('search'))
		{
			$search					= Input::get('search');

			foreach ($search as $key => $value) 
			{
				switch (strtolower($key)) 
				{
					case '_id':
						$result		= $result->id($value);
						break;
					case 'title':
						$result		= $result->title($value);
						break;
					case 'slug':
						$result		= $result->slug($value);
						break;
					case 'owner':
						$result		= $result->ownerid($value);
						break;
					default:
						# code...
						break;
				}
			}
		}

		if(Input::has('sort'))
		{
			$sort					= Input::get('sort');

			foreach ($sort as $key => $value) 
			{
				if(!in_array($value, ['asc', 'desc']))
				{
					return response()->json( JSend::error([$key.' harus bernilai asc atau desc.'])->asArray());
				}
				switch (strtolower($key)) 
				{
					case 'newest':
						$result		= $result->orderby('created_at', $value);
						break;
					case 'title':
						$result		= $result->orderby($key, $value);
						break;
					default:
						# code...
						break;
				}
			}
		}
		else
		{
			$result		= $result->orderby('created_at', 'asc');
		}

		$count						= count($result->get());

		if(Input::has('skip'))
		{
			$skip					= Input::get('skip');
			$result					= $result->skip($skip);
		}

		if(Input::has('take'))
		{
			$take					= Input::get('take');
			$result					= $result->take($take);
		}

		$result 					= $result->get();
		
		return response()->json( JSend::success(['data' => $result->toArray(), 'count' => $count])->asArray())
				->setCallback($this->request->input('callback'));
	}

	/**
	 * Store Policy
	 *
	 * @Post("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"_id":"string","title":"string","slug":"string","contents":{"key":"string","value":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}}),
	 *      @Response(200, body={"status": "success", "data": {"_id":"string","title":"string","slug":"string","contents":{"key":"string","value":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}}}),
	 *      @Response(200, body={"status": {"error": {"code must be unique."}}})
	 * })
	 */
	public function post()
	{
		$id 			= Input::get('_id');

		if(!is_null($id) && !empty($id))
		{
			$result		= Policy::id($id)->first();
		}
		else
		{
			$result 	= new Policy;
		}
		

		$result->fill(Input::only('title', 'contents', 'issued'));

		if($result->save())
		{
			return response()->json( JSend::success($result->toArray())->asArray())
					->setCallback($this->request->input('callback'));
		}
		
		return response()->json( JSend::error($result->getError())->asArray());
	}

	/**
	 * Delete Policy
	 *
	 * @Delete("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"id":null}),
	 *      @Response(200, body={"status": "success", "data": {"_id":"string","title":"string","slug":"string","contents":{"key":"string","value":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}}}),
	 *      @Response(200, body={"status": {"error": {"code must be unique."}}})
	 * })
	 */
	public function delete()
	{
		$policy		= Policy::id(Input::get('_id'))->first();
		
		$result 		= $policy;

		if($policy && $policy->delete())
		{
			return response()->json( JSend::success($result->toArray())->asArray())
					->setCallback($this->request->input('callback'));
		}

		if(!$policy)
		{
			return response()->json( JSend::error(['ID tidak valid'])->asArray());
		}

		return response()->json( JSend::error($policy->getError())->asArray());
	}
}