<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
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
        $category = \App\Category::all();
        return view('category', ['page_title' => 'Categories', 'categories' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category_create', ['page_title' => 'Add Category', 'url_action' => url('category'), 'method' => 'POST']);
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('category/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $category = new \App\Category;
        $category->name = $request->name;
        $category->description = $request->description;

        if($category->save()) {
            return redirect('category')->with('success', 'Category saved!');
        } else {
            return redirect('category/create')->with('error', 'Failed to save!');
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
        $category = \App\Category::find($id);
        if(!$category) {
            return redirect('category')->with('error', 'Data not found!');
        }
        return view('category_create', ['page_title' => 'Edit Category', 'category' => $category, 'url_action' => url("category/$id"), 'method' => 'PUT']);
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
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('category/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $category = \App\Category::find($id);
        if(!$category) {
            return redirect('category')->with('error', 'Data not found!');;
        }
        $category->name = $request->name;
        $category->description = $request->description;

        if($category->save()) {
            return redirect('category')->with('success', 'Category updated!');
        } else {
            return redirect("category/$id/edit")->with('error', 'Failed to update!');
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
        $category = \App\Category::find($id);
        if($category && $category->delete()) {
            $response = [
                'status' => [
                    'code' => 200,
                    'error' => false,
                    'message' => 'delete category successful'
                ]
            ];
        } else {
            $response = [
                'status' => [
                    'code' => 400,
                    'error' => true,
                    'message' => 'delete category failed'
                ]
            ];
        }
        return response()->json($response);
    }
}
