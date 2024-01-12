<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function AllCategory(){
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category',compact('category'));
    }//End Method

    public function AddCategory(){
        $category = Category::latest()->get();
        return view('admin.backend.category.add_category',compact('category'));
    }//End Method
    
}
