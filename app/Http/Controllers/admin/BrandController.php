<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // view category page
    public function index(Request $request)
    {
        $brands = Brand::latest();

        if (!empty($request->get('keyword'))) {
            $brands = $brands->where('name', 'like', '%' . $request->keyword . '%');
        }

        $brands = $brands->paginate(10);
        return view('admin.brand.brandList', compact('brands'));
    }

    //get category add page
    public function create()
    {
        return view('admin.brand.createBrand');
    }

    //store category 
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|unique:brands',
            'status' => 'required',
        ]);

        if ($validator) {

            $brand = new Brand();
            $brand->name = trim($request->name);
            $brand->slug = strtolower(str_replace(' ', '-', $request->name));
            $brand->status = $request->status;
            $brand->save();

            return redirect()->route('brands.create')->with('success', 'Brand added successfully.');
        } else {
            return redirect()->route('brands.create')->withErrors($validator)->withInput();
        }
    }


    // get brand edit page
    public function edit($brandId, Request $request)
    {
        $brand = Brand::find($brandId);

        if (empty($brand)) {
            return redirect()->route('brands.index')->with('error', 'Brand not found!');
        }
        return view('admin.brand.editBrand', compact('brand'));
    }

    // //update category
    public function update($brandId, Request $request)
    {
        $brand = Brand::find($brandId);

        if (empty($brand)) {
            return redirect()->route('categories.index');
        }

        $validator = $request->validate([
            'name' => 'required|unique:categories,name,' . $brand->id . ',id',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5048',
            'status' => 'required',
        ]);

        if ($validator) {

            $brand->name = trim($request->name);
            $brand->slug = strtolower(str_replace(' ', '-', $request->name));
            $brand->status = $request->status;
            $brand->save();

            return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
        } else {
            return redirect()->route('Brands.create')->withErrors($validator)->withInput();
        }
    }

    // //delete category 
    public function destroy($brandId)
    {
        Brand::findOrFail($brandId)->delete();
        return redirect()->route('brands.index');
    }
}
