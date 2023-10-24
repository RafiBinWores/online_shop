<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // view category page
    public function index(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%' . $request->keyword . '%');
        }

        $categories = $categories->paginate(10);
        return view('admin.category.categoryList', compact('categories'));
    }

    //get category add page
    public function create()
    {
        return view('admin.category.create');
    }

    //store category 
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|unique:categories',
            'status' => 'required',
        ]);

        if ($validator) {

            $category = new Category();
            $category->name = trim($request->name);
            $category->slug = strtolower(str_replace(' ', '-', $request->name));
            $category->status = $request->status;
            $category->save();

            return redirect()->route('categories.create')->with('success', 'Category added successfully.');
        } else {
            return redirect()->route('categories.create')->withErrors($validator)->withInput();
        }
    }


    // get category edit page
    public function edit()
    {
    }

    //update category
    public function update()
    {
    }

    //delete category 
    public function destroy()
    {
    }
}
