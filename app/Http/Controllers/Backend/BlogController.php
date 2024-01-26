<?php

namespace App\Http\Controllers\Backend;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    public function AllBlogCategory(){

        $category = BlogCategory::latest()->get();
        return view('admin.backend.blogcategory.blog_category',compact('category'));
    
       }// End Method 

       public function StoreBlogCategory(Request $request){

        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);
    
        $notification = array(
            'message' => 'BlogCategory Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    
    
       }// End Method 
       public function EditBlogCategory($id){

        $categories = BlogCategory::find($id);
        return response()->json($categories);
    
       }// End Method 

       public function UpdateBlogCategory(Request $request){
        $cat_id = $request->cat_id;
    
        BlogCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
        ]);
    
        $notification = array(
            'message' => 'BlogCategory Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    
    
       }// End Method 
    
       public function DeleteBlogCategory($id){
    
        BlogCategory::find($id)->delete();
    
        $notification = array(
            'message' => 'BlogCategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    
    
       }// End Method 

       //////////// All Blog Post Method .//

   public function BlogPost(){
    $post = BlogPost::latest()->get();
    return view('admin.backend.post.all_post',compact('post'));
   }// End Method 
}
