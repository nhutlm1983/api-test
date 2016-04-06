<?php 
namespace App\Http\Controllers;

use App\Tag;
use Response;
use Validator;
use Input;
use stdClass;

class TagController extends Controller 
{
	
	public function index()
	{

	}

	public function gets()
	{
		$response = new stdClass;
		$response->error   = 0;
		$response->status  ='success';
		$response->message = "Successfully";
		$response->tags    = Tag::paginate( $this->limit );
		return Response::json( $response );
	}
	
	public function post()
	{
		$response = new stdClass;
		$response->error   = -1;
		$response->status  ='invalid';
		$response->message = "";
		
		$name = Input::get('name', null);
		if( isset( $name ) )
		{
			$tag = new Tag;
	        $tag->name = $name;
	        $tag->save();
	        $response->tag = $tag;
	        $response->error = 0;
	        $response->status='success';
    	}
		return Response::json( $response );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function get($id)
	{
		$response = new stdClass;
		$response->error   = 0;
		$response->status  ='success';
		$response->tag = Tag::find( $id );
		return Response::json( $response );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$response = new stdClass;
		$response->error   = -1;
		$response->status  ='invalid';
		$response->message = "";
		$tag = Tag::find( $id );
		$name = Input::get('name', null);
		if( isset( $tag->id ) 
			&& isset( $name ) 
			&& $tag->name != $name )
		{
	        $tag->name = $name;
	        $tag->save();
	        $response->error = 0;
	        $response->status='success';
    	}
    	$response->tag = $tag;
		return Response::json( $response );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$response = new stdClass;
		$response->error   = -1;
		$response->status  ='invalid';
		$response->message = "";
		$tag = Tag::find( $id );

		if( isset( $tag->id ) )
		{
			$response->tag = $tag;
	        $tag->delete();
	        $response->error = 0;
	        $response->status='success';
    	}
		return Response::json( $response );
	}
}
