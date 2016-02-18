<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Validator;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = \App\Post::all();
        $post->load('category');
        return view('post', ['page_title' => 'Posts', 'posts' => $post]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::all();
        return view('post_create', ['page_title' => 'Add Post', 'categories' => $categories, 'url_action' => url('post'), 'method' => 'POST']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $post = new \App\Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category;
        $post->status = $request->status;
        $post->user_id = auth()->user()->id;

        if($post->save()) {
            return redirect('post')->with('success', 'Post saved!');
        } else {
            return redirect('post/create')->with('error', 'Failed to save!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = \App\Post::find($id);
        if(!$post) {
            return redirect('post')->with('error', 'Data not found!');
        }
        $post->load('category');
        $categories = \App\Category::all();
        return view('post_create', ['page_title' => 'Edit Post', 'categories' => $categories, 'post' => $post, 'url_action' => url("post/$id"), 'method' => 'PUT']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $post = \App\Post::find($id);
        if(!$post) {
            return redirect('post')->with('error', 'Data not found!');;
        }
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category;
        $post->status = $request->status;
        $post->user_id = auth()->user()->id;

        if($post->save()) {
            return redirect('post')->with('success', 'Post updated!');
        } else {
            return redirect("post/$id/edit")->with('error', 'Failed to update!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = \App\Post::find($id);
        if($post && $post->delete()) {
            $response = [
                'status' => [
                    'code' => 200,
                    'error' => false,
                    'message' => 'delete post successful'
                ]
            ];
        } else {
            $response = [
                'status' => [
                    'code' => 400,
                    'error' => true,
                    'message' => 'delete post failed'
                ]
            ];
        }
        return response()->json($response);
    }
}
