<?php

namespace App\Http\Controllers;

use App\Category;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(50);
        return view('pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories'
        ]);

        $category = new Category();
        $category->name = $request->get('name');
        $category->company_id = 1;
        $category->user_id = Auth::id();
        $category->description = $request->get('description') ?? null;
        $category->save();

        return redirect()->back()->with('success', 'Category added successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (!$category) {
            return redirect()->back()->with('warning', 'The category you wanted to edit does not exist.');
        }

        return view('pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if (!$category) {
            return redirect()->back()->with('warning', 'The category you wanted to edit does not exist.');
        }

        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $category->name = $request->get('name');
        $category->description = $request->get('description') ?? null;
        $category->save();

        return redirect()->action('CategoryController@index')->with('success', 'category updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();
        }

        return redirect()->action('CategoryController@index')->with('success', 'Category deleted successfully!');
    }
}
