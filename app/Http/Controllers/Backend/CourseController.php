<?php

namespace App\Http\Controllers\Backend;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function AllCourse(){

        $id = Auth::user()->id;
        $courses = Course::where('instructor_id',$id)->orderBy('id','desc')->get();
          return view('instructor.courses.all_course',compact('courses'));
  
      }// End Method 
}
