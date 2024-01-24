<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
    public function AddToCart(Request $request, $id){
        $course = Course::find($id);


        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        // Check if the course is already in the cart
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });
        if ($cartItem->isNotEmpty()) {
            return response()->json(['error' => 'Course is already in your cart']);
        }

        if ($course->discount_price == NULL) {

            Cart::add([
                'id' => $id, 
                'name' => $request->course_name, 
                'qty' => 1, 
                'price' => $course->selling_price, 
                'weight' => 1, 
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                ],
            ]); 

        }else{

            Cart::add([
                'id' => $id, 
                'name' => $request->course_name, 
                'qty' => 1, 
                'price' => $course->discount_price, 
                'weight' => 1, 
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                ],
            ]);  
        }

        return response()->json(['success' => 'Successfully Added on Your Cart']); 

    }// End Method 

    public function CartData(){

        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));

    }// End Method 

    public function AddMiniCart(){

        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));

    }// End Method 

    public function RemoveMiniCart($rowId){

        Cart::remove($rowId);
        return response()->json(['success' => 'Course Remove From Cart']);

    }// End Method 

    public function MyCart(){

        return view('frontend.mycart.view_mycart');

    } // End Method 

    public function GetCartCourse(){

        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));

    }// End Method 

    public function CartRemove($rowId){

        Cart::remove($rowId);
        if (Session::has('coupon')) {
            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();
 
            Session::put('coupon',[
             'coupon_name' => $coupon->coupon_name,
             'coupon_discount' => $coupon->coupon_discount,
             'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
             'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100 )
         ]);
 
         }
        return response()->json(['success' => 'Course Remove From Cart']);

    }// End Method 

    public function CouponApply(Request $request){
        $coupon = Coupon::where('coupon_name',$request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first(); 

        if ($coupon) {
            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100 )
            ]);

            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Successfully'
            ));

        }else {
            return response()->json(['error' => 'Invaild Coupon']);
        }
}// End Method 

public function CouponCalculation(){

    if (Session::has('coupon')) {
       return response()->json(array(
        'subtotal' => Cart::total(),
        'coupon_name' => session()->get('coupon')['coupon_name'],
        'coupon_discount' => session()->get('coupon')['coupon_discount'],
        'discount_amount' => session()->get('coupon')['discount_amount'],
        'total_amount' => session()->get('coupon')['total_amount'],
       ));
    } else{
        return response()->json(array(
            'total' => Cart::total(),
        ));
    }

}// End Method 

public function CouponRemove(){

    Session::forget('coupon');
    return response()->json(['success' => 'Coupon Remove Successfully']);

}// End Method 

}