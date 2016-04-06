<?php namespace App\Http\Controllers;

use App\Posts;
use App\Tag;
use App\Http\Controllers\Controller;
use Response;
use stdClass;
use Input;
class PostController extends Controller 
{
	public function index(){}
	
	public function gets()
	{
		$response = new stdClass;
		$response->error  = 0;
		$response->status = 'success';
		$response->posts  = Posts::where('active','1')
				->orderBy('created_at','desc')
				->paginate( $this->limit );
		return Response::json( $response );
	}

	public function get( $id )
	{
		$response = new stdClass;
		$response->error  = 0;
		$response->status = 'success';
		$response->post  = Posts::find( $id );
		return Response::json( $response );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function create()
	{
		$response = new stdClass;
		$response->error  = 0;
		$response->status = 'success';
		$post        = new Posts();
		$post->title = Input::get('title');
		$post->body  = Input::get('body');
		$post->slug  = str_slug($post->title);
		$post->author_id = 1;
		$post->active = 1;
		$post->save();

		$response->post = $post;
		return Response::json( $response );
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update( $id )
	{
		$response = new stdClass;
		$response->error  = -1;
		$response->status = 'invalid';
		$post = Posts::find($id);

		if( isset( $post->id ) )
		{
			$title     = Input::get('title');
			$slug      = str_slug($title);
			
			$post->title = $title;
			$post->body = Input::get('body');
			$post->save();
			
	 		$response->post = $post;
	 		$response->error = 0;
	 		$response->status = 'success';
		}
		return Response::json( $response );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy( $id )
	{
		$response = new stdClass;
		$response->error  = -1;
		$response->status = 'invalid';

		$post = Posts::find($id);
		if( isset( $post->id ) )
		{
			$response->post = $post;
			$post->delete();
			$response->error  = 0;
			$response->status = 'success';
		}
		return Response::json( $response );
	}

	public function tags( $id )
	{
		$response = new stdClass;
		$response->error  = -1;
		$response->status = 'invalid';

		$post = Posts::find($id);

		if( isset( $post->id ) )
		{
			$response->tags = $post->tags;
			$post->delete();
			$response->error  = 0;
			$response->status = 'success';
		}

		return Response::json( $response );
	}

	public function assign( $id )
	{
		$response = new stdClass;
		$response->error  = -1;
		$response->status = 'invalid';

		$post = Posts::find($id);

		if( isset( $post->id ) )
		{
			$tags = Input::get('tags', null);
			if( isset( $tags ) )
			{
				$arrTags = explode(',', $tags);

				if( count( $arrTags )  > 0 )
				{
					foreach ($arrTags as $key => $tagName) 
					{
						$tag = Tag::firstOrCreate(['name' => $tagName]);
						$post->tags()->save($tag);
					}
					$response->tags = $post->tags;
					$response->error  = 0;
					$response->status = 'success';
				}
				
			}
		}
		return Response::json( $response );
	}
}
