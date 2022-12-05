<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.detail', compact('post'));
    }

    public function comment($blog_id,Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 200);
        } else {
            $data = [
                'user_id' => $user_id,
                'blog_id' => $blog_id,
                'content' => $request->content,
                'reply_id' => $request->reply_id ? $request->reply_id : 0
            ];
            $comment = Comment::create($data);
            if($comment){
                $comments = Comment::where(['blog_id' => $blog_id, 'reply_id' => 0])->get();
                // return response()->json(['data' =>  $comments], 200);
                return view('posts.list_comment', compact('comments'));
            }
        }
    }

    public function add(){
        return view('posts.add');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' =>'required',
            'content' => 'required',
        ]);
        // $validator->validate();
        if ($validator->passes()) {

            Post::create($request->all()); // it store data to the DB

            return response()->json(['success'=>'Added new records.']);

        }else{
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ));
        }


    }
}
