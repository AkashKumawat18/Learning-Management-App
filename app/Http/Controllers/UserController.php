<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Index(){
        return view('frontend.index');
    }//End Method

    public function UserProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.edit_profile',compact('profileData'));
    }//End Method

    public function UserProfileUpdate(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
           $file = $request->file('photo');
           @unlink(public_path('upload/user_images/'.$data->photo));
           $filename = date('YmdHi').$file->getClientOriginalName();
           $file->move(public_path('upload/user_images'),$filename);
           $data['photo'] = $filename; 
        }

        $data->save();

        $notification = array(
            'message' => 'Admin profile updated successfully',
            'alert-type' => 'success'
        ); 

        return redirect()->back()->with($notification);
    }//End Method

    public function UserLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }//End Method

    public function UserChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.change_password',compact('profileData'));
    }

    public function UserPasswordUpdate(Request $request){
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
            'message' => 'User Password Updated Successfully',
            'alert-type' => 'success'
        ); 

        return back()->with($notification);
    }// End Method

}
