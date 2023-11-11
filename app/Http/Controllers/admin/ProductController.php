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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
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
    public function index(Request $request)
    {
        $products = Product::latest('id')->with('product_images');

        if (!empty($request->get('keyword'))) {
            $products = $products->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $products->paginate(10);
        $data['products'] = $products;
        return view('admin.product.productList', $data);
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

            $request->session()->flash('success', 'Product added successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Product added successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }

    // get product edit page
    public function edit($id, Request $request)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('products.index')->with('error', 'Product not found!');
        }

        $productImages = ProductImage::where('product_id', $product->id)->get();
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();

        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        $data['product'] = $product;
        $data['productImages'] = $productImages;
        $data['brands'] = $brands;
        $data['categories'] = $categories;
        $data['subCategories'] = $subCategories;

        return view('admin.product.editProduct', $data);
    }

    //update product
    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $rules = [
            'name' => 'required|unique:products,name,' . $product->id . ',id',
            'price' => 'required|numeric',
            'description' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id . ',id',
            'track_quantity' => 'required|in:Yes,No',
            'is_featured' => 'required|in:Yes,No',
            'category_id' => 'required|numeric',
        ];

        if (!empty($request->track_quantity) && $request->track_quantity == 'Yes') {
            $rules['quantity'] = 'required|numeric';
        }

        $validation = Validator::make($request->all(), $rules);

        if ($validation->passes()) {

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

            $request->session()->flash('success', 'Product updated successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }
    }

    //delete product 
    public function destroy($id, Request $request)
    {
        $product = Product::find($id);

        if (empty($product)) {
            $request->session()->flash('error', 'Product not found!');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $productImages = ProductImage::where('product_id', $id)->get();

        if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                File::delete(public_path('/uploads/products/large/' . $productImage->image));
                File::delete(public_path('/uploads/products/small/' . $productImage->image));
            }
            ProductImage::where('product_id', $id)->delete();
        }

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }
}
