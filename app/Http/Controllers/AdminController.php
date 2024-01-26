<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard(){
        return view("admin.index");
    }
    public function AdminLogout(Request $request) 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        
        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'info'
        );

        return redirect('/admin/login')->with($notification);
    }// End Method

    public function AdminLogin(){
        return view("admin.admin_login");
    }// End Method


    public function AdminProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view',compact('profileData'));
    }// End Method

      public function AdminProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
           $file = $request->file('photo');
           @unlink(public_path('upload/admin_images/'.$data->photo));
           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/admin_images'),$filename);
           $data['photo'] = $filename; 
        }

        $data->save();

        $notification = array(
            'message' => 'Admin profile updated successfully',
            'alert-type' => 'success'
        ); 

        return redirect()->back()->with($notification);

    }// End Method

    public function AdminChangePassword(Request $request){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password',compact('profileData'));
    }// End Method

    public function AdminPasswordUpdate(Request $request){
        $request->validate([
            'old_password'=>"required",
            'new_password'=>'required|confirmed'
        ]);

        if(!Hash::check($request->old_password,Auth::user()->password)){
            $notification = array(
                'message' => 'Old Password Does Not Match!',
                'alert-type' => 'error'
            ); 
    
            return back()->with($notification);
        }

        /// Update The new Password 
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        $notification = array(
            'message' => 'Admin Password Updated Successfully',
            'alert-type' => 'success'
        ); 

        return back()->with($notification);
    }// End Method

    public function BecomeInstructor(){

        return view('frontend.instructor.reg_instructor');

    }// End Method

    public function InstructorRegister(Request $request){

        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required', 'string','unique:users'],
        ]);

        User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' =>  Hash::make($request->password),
            'role' => 'instructor',
            'status' => '0',
        ]);

        $notification = array(
            'message' => 'Instructor Registed Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('instructor.login')->with($notification); 

    }// End Method


    public function AllInstructor(){

        $allinstructor = User::where('role','instructor')->latest()->get();
        return view('admin.backend.instructor.all_instructor',compact('allinstructor'));
    }// End Method
     

    public function UpdateUserStatus(Request $request){

        $userId = $request->input('user_id');
        $isChecked = $request->input('is_checked',0);

        $user = User::find($userId);
        if ($user) {
            $user->status = $isChecked;
            $user->save();
        }

        return response()->json(['message' => 'User Status Updated Successfully']);

    }// End Method

    public function AdminAllCourse(){

        $course = Course::latest()->get();
        return view('admin.backend.courses.all_course',compact('course'));

    }// End Method

    public function UpdateCourseStatus(Request $request){

        $courseId = $request->input('course_id');
        $isChecked = $request->input('is_checked',0);

        $course = Course::find($courseId);
        if ($course) {
            $course->status = $isChecked;
            $course->save();
        }

        return response()->json(['message' => 'Course Status Updated Successfully']);

    }// End Method

    public function AdminCourseDetails($id){

        $course = Course::find($id);
        return view('admin.backend.courses.course_details',compact('course'));

    }// End Method
}
