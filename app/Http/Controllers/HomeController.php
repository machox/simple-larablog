<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = \App\Post::where('status', 'published')->get();
        $posts->load('category');
        $posts->load('user');
        $categories = \App\Category::all();
        return view('home', ['title' => 'Home', 'posts' => $posts, 'categories' => $categories]);
    }

    public function category($id)
    {
        $posts = \App\Post::where('status', 'published')->where('category_id', $id)->get();
        $posts->load('category');
        $posts->load('user');
        $categories = \App\Category::all();
        $title = \App\Category::find($id);
        if(!$title) 
            $t = "Data Not Found";
        else
            $t = "Category $title->name";
        return view('home', ['title' => $t, 'posts' => $posts, 'categories' => $categories]);
    }

    public function show($id) 
    {
        $post = \App\Post::where('status', 'published')->find($id);
        if($post) {
            $post->load('category');
            $post->load('user');
        }
        $categories = \App\Category::all();
        return view('home_show', ['post' => $post, 'categories' => $categories]);
    }
}
