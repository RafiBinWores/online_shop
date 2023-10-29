<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // view product page
    public function index()
    {
    }

    //get product add page
    public function create()
    {
        return view('admin.product.createProduct');
    }

    //store product 
    public function store()
    {
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
