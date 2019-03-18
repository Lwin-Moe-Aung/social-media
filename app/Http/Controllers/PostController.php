<?php


namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Log\Contracts\Log;


class PostController extends Controller
{
	protected $log;

	public function __construct(log $log){

		$this->log = $log;

	}
	public function getDashboard(){
		$posts = Post::orderBy('created_at', 'desc')->get();
		return view('dashboard', ['posts'=>$posts]);
	}
	
	public function postCreatePost( Request $request)
	{
		$this->validate($request, [
			'body' => 'required|max:1000'
		]);
		$post = new Post();
		$post->body = $request['body'];
		$message = 'There was an error';
		if ($request->user()->posts()->save($post)) {
			$message = 'Post successfully created!';
		}
		//var_dump($request->user()->id);die();

		// for log
		$user_id = $request->user()->id;
		$detail = [
			'user_id' => $user_id,
			'message' => 'post create'
		];
		$detail = json_encode($detail,true);
		$table = "posts";
		$data = $this->log->format($detail, $table, $user_id );
		
		$this->log->save($data);



		return redirect()->route('dashboard')->with(['message' => $message]);
	}

	public function getDeletePost( $post_id )
	{
		$post = Post::where('id', $post_id)->first();
		if ( Auth::user() != $post->user) {
			return redirect()->back();
		}
		$post->delete();

		// for log
		$user_id = Auth::user()->id;
		$detail = [
			'user_id' => $post_id,
			'message' => 'post delete'
		];
		$detail = json_encode($detail,true);
		$table = "posts";
		$data = $this->log->format($detail, $table, $user_id );
		
		$this->log->save($data);


		return redirect()->route('dashboard')->with(['message' => 'Successfully deleted']);
	}

	public function postEditPost(Request $request)
	{
		//var_dump($request['postId']);die();
		
		$post = Post::find($request['postId']);
		$post->body = $request['body'];
		$post->update();

		// for log
		$user_id = $request->user()->id;
		$detail = [
			'user_id' => $user_id,
			'message' => 'post edit'
		];
		$detail = json_encode($detail,true);
		$table = "posts";
		$data = $this->log->format($detail, $table, $user_id );
		
		$this->log->save($data);

		return response()->json(['message' => $post->body], 200);

	}
}