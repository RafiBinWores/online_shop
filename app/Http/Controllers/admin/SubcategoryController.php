<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    //get subcategory list page
    public function index(Request $request)
    {
        $subcategories = Subcategory::latest();

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
            'subcategory_name' => 'required|unique:subcategories',
            'category_id' => 'required',
            // 'status' => 'required',
        ]);

        if ($validator) {

            $category_id = $request->category_id;
            $category_name = Category::where('id', $category_id)->value('name');

            $subcategory = new Subcategory();
            $subcategory->subcategory_name = trim($request->subcategory_name);
            $subcategory->slug = strtolower(str_replace(' ', '-', $request->subcategory_name));
            $subcategory->category_id = $category_id;
            $subcategory->category_name = $category_name;
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
        $subcategory = Subcategory::find($subcategoryId);

        if (empty($subcategory)) {
            return redirect()->route('subcategories.index')->with('error', 'Subcategory not found!');
        }
        return view('admin.subCategory.editSubcategory', compact('subcategory'));
    }

    //update sub category 
    public function update($subcategoryId, Request $request)
    {
        $subcategory = Subcategory::find($subcategoryId);

        if (empty($subcategory)) {
            return redirect()->route('subcategories.index');
        }

        $validator = $request->validate([
            'subcategory_name' => 'required|unique:subcategories,subcategory_name,' . $subcategory->id . ',id',
        ]);

        if ($validator) {

            $subcategory->subcategory_name = trim($request->subcategory_name);
            $subcategory->slug = strtolower(str_replace(' ', '-', $request->subcategory_name));
            $subcategory->save();

            return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
        } else {
            return redirect()->route('subcategories.create')->withErrors($validator)->withInput();
        }
    }

    //delete sub category
    public function destroy($subcategoryId)
    {
        $categoryId = Subcategory::where('id', $subcategoryId)->value('category_id');
        Subcategory::findOrFail($subcategoryId)->delete();

        Category::where('id', $categoryId)->decrement('subcategory_count', 1);

        return redirect()->route('subcategories.index');
    }
}
