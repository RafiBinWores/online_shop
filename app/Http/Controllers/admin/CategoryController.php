<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5048',
            'status' => 'required',
        ]);

        if ($validator) {

            if ($request->hasFile('image')) {
                $newImageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path() . '/uploads/category/', $newImageName);
            } else {
                $newImageName = null;
            }

            $category = new Category();
            $category->name = trim($request->name);
            $category->slug = strtolower(str_replace(' ', '-', $request->name));
            $category->image = $newImageName;
            $category->status = $request->status;
            $category->save();

            return redirect()->route('categories.index')->with('success', 'Category added successfully.');
        } else {
            return redirect()->route('categories.create')->withErrors($validator)->withInput();
        }
    }


    // get category edit page
    public function edit($categoryId, Request $request)
    {
        $category = Category::find($categoryId);

        if (empty($category)) {
            return redirect()->route('categories.index')->with('error', 'Category not found!');
        }
        return view('admin.category.editCategory', compact('category'));
    }

    //update category
    public function update($categoryId, Request $request)
    {
        $category = Category::find($categoryId);

        if (empty($category)) {
            return redirect()->route('categories.index');
        }

        $validator = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . ',id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5048',
            'status' => 'required',
        ]);

        if ($validator) {

            if ($request->hasFile('image')) {
                $oldImage = $category->image;

                $newImageName = $category->slug . '-' . time() . '.' . $request->image->extension();
                $request->image->move(public_path() . '/uploads/category/', $newImageName);

                File::delete(public_path() . '/uploads/category/' . $oldImage);
            } else {
                $newImageName = null;
            }

            $category->name = trim($request->name);
            $category->slug = strtolower(str_replace(' ', '-', $request->name));
            $category->image = $newImageName;
            $category->status = $request->status;
            $category->save();

            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } else {
            return redirect()->route('categories.create')->withErrors($validator)->withInput();
        }
    }

    //delete category 
    public function destroy($categoryId)
    {
        $category = Category::find($categoryId);

        if ($category) {

            File::delete(public_path() . '/uploads/category/' . $category->image);
            $category->delete();

            return redirect()->route('categories.index');
        }

        return redirect()->route('categories.index');
    }
}
