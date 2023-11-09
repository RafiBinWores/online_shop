<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ProductController extends Controller
{
    //getting subcategories
    public function subCategory(Request $request)
    {
        if (!empty($request->category_id)) {
            $subCategories = SubCategory::where('category_id', $request->category_id)->orderBy('name', 'ASC')->get();

            return response()->json([
                'status' => true,
                'subCategories' => $subCategories
            ]);
        } else {
            return response()->json([
                'status' => true,
                'subCategories' => []
            ]);
        }
    }

    // view product page
    public function index()
    {
    }

    //get product add page
    public function create()
    {
        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.product.createProduct', $data);
    }

    //store product 
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:products',
            'price' => 'required|numeric',
            'description' => 'required',
            'sku' => 'required|unique:products',
            'track_quantity' => 'required|in:Yes,No',
            'is_featured' => 'required|in:Yes,No',
            'category_id' => 'required|numeric',
        ];

        if (!empty($request->track_quantity) && $request->track_quantity == 'Yes') {
            $rules['quantity'] = 'required|numeric';
        }

        $validation = Validator::make($request->all(), $rules);

        if ($validation->passes()) {

            $product = new Product();
            $product->name = $request->name;
            $product->slug = strtolower(str_replace(' ', '-', $request->name));
            $product->brand_id = $request->brand;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->description = $request->description;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_quantity = $request->track_quantity;
            $product->quantity = $request->quantity;
            $product->status = $request->status;
            $product->is_featured = $request->is_featured;
            $product->category_id = $request->category_id;
            $product->sub_category_id  = $request->subCategory;
            $product->price = $request->price;
            $product->save();

            //save images
            if (!empty($request->images)) {
                foreach ($request->images as $tempImageId) {

                    $tempImgInfo = TempImage::find($tempImageId);
                    $extArray = explode('.', $tempImgInfo->name);
                    $ext = last($extArray);

                    $productImages = new ProductImage();
                    $productImages->product_id = $product->id;
                    $productImages->image = 'NULL';
                    $productImages->save();

                    $imageName = $product->id . '-' . $productImages->id . '-' . time() . '.' . $ext;
                    $productImages->image = $imageName;
                    $productImages->save();

                    //large image
                    $sourcePath = public_path() . '/temp/' . $tempImgInfo->name;
                    $destPath = public_path() . '/uploads/products/large/' . $imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(1400, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($destPath);

                    // small image
                    $destPath = public_path() . '/uploads/products/small/' . $imageName;
                    $image = Image::make($sourcePath);
                    $image->fit(300, 275);
                    $image->save($destPath);
                };
            }



            return redirect()->route('products.store')->with('success', 'Product added successfully.');
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }

    // get product edit page
    public function edit()
    {
    }

    //update product
    public function update()
    {
    }

    //delete product 
    public function destroy()
    {
    }
}
