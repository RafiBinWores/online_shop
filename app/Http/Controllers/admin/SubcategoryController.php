<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //get subcategory list page
    public function index(Request $request)
    {
        $subcategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')->latest()->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        if (!empty($request->get('keyword'))) {
            $subcategories = $subcategories->where('subcategory_name', 'like', '%' . $request->keyword . '%');
        }

        $subcategories = $subcategories->paginate(10);
        return view('admin.subCategory.subcategoryList', compact('subcategories'));
    }

    //get subcategory add page
    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.subCategory.createSubcategory', compact('categories'));
    }

    //store subcategory 
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|unique:sub_categories',
            'status' => 'required',
            'category_id' => 'required',

        ]);

        if ($validator) {

            $category_id = $request->category_id;

            $subcategory = new SubCategory();
            $subcategory->name = trim($request->name);
            $subcategory->slug = strtolower(str_replace(' ', '-', $request->name));
            $subcategory->status = $request->status;
            $subcategory->category_id = $category_id;
            $subcategory->save();

            Category::where('id', $category_id)->increment('subcategory_count', 1);

            return redirect()->route('subcategories.index')->with('success', 'Subcategory added successfully.');
        } else {
            return redirect()->route('subcategories.create')->withErrors($validator)->withInput();
        }
    }

    //get subcategory edit page
    public function edit($subcategoryId)
    {
        $subcategory = SubCategory::find($subcategoryId);

        if (empty($subcategory)) {
            return redirect()->route('subcategories.index')->with('error', 'Subcategory not found!');
        }
        return view('admin.subCategory.editSubcategory', compact('subcategory'));
    }

    //update sub category 
    public function update($subcategoryId, Request $request)
    {
        $subcategory = SubCategory::find($subcategoryId);

        if (empty($subcategory)) {
            return redirect()->route('subcategories.index');
        }

        $validator = $request->validate([
            'name' => 'required|unique:sub_categories,name,' . $subcategory->id . ',id',
            'status' => 'required'
        ]);

        if ($validator) {

            $subcategory->name = trim($request->name);
            $subcategory->slug = strtolower(str_replace(' ', '-', $request->name));
            $subcategory->status = $request->status;
            $subcategory->save();

            return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
        } else {
            return redirect()->route('subcategories.create')->withErrors($validator)->withInput();
        }
    }

    //delete sub category
    public function destroy($subcategoryId)
    {
        $categoryId = SubCategory::where('id', $subcategoryId)->value('category_id');
        SubCategory::findOrFail($subcategoryId)->delete();

        Category::where('id', $categoryId)->decrement('subcategory_count', 1);

        return redirect()->route('subcategories.index');
    }
}
