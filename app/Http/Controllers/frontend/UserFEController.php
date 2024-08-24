<?php

namespace App\Http\Controllers\frontend;

use App\Models\Country;
use App\Models\AddressBook;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Hash;

class UserFEController extends Controller
{
    public function profile()
    {
        return view('frontend.users.profile');
    }
    
    public function changePassword()
    {
        return view('frontend.users.change-password');
    }
    public function updateUserPassword(Request $request,$id)
    {
        return $bool = User::find($id)->update(['password'=>Hash::make($request->new_password)]);
    }

    public function checkUserPassword(Request $request)
    {
        if(Hash::check($request->current_password, Auth::guard('web')->user()->password)){
            return true;
        }else{
            return false;
        }
    }

    public function update(Request $request)
    {

        $data = $request->all();
        if(isset($data['image'])){
            $image = 'user-'. time().'.'.$data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('uploads/user'), $image);
            $data['image'] = $image;
            if(Auth::guard('web')->user()->image){
                unlink(public_path('uploads/user/').Auth::guard('web')->user()->image);
            }
        }
        User::find(Auth::guard('web')->user()->id)->update($data);
        return redirect()->back()->with('alert',['messageType'=>'success','message'=> 'Data Updated Successfully!']);
    }

    public function addressBook()
    {
        $user_id = Auth::guard('web')->user()->id;
        $countries = Country::where('status', '=', 1)->get();
        $address = AddressBook::where('user_id','=',$user_id)->first();
        
        return view('frontend.users.addressbook', compact('countries','address'));
    }
    public function addressStore(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['user_id'] = Auth::guard('web')->user()->id;

        if(!isset($data['stda'])){
            $data['shipping_first_name'] = $data['billing_first_name'];
            $data['shipping_last_name'] = $data['billing_last_name'];
            $data['shipping_company_name'] = $data['billing_company_name'];
            $data['shipping_country_id'] = $data['billing_country_id'];
            $data['shipping_street_address'] = $data['billing_street_address'];
            $data['shipping_city'] = $data['billing_city'];
            $data['shipping_state'] = $data['billing_state'];
            $data['shipping_zip_code'] = $data['billing_zip_code'];
            $data['shipping_phone'] = $data['billing_phone'];
            $data['shipping_email'] = $data['billing_email'];
        }

        if(!$data['address_id']){
            unset($data['address_id']);
            AddressBook::create($data);
            $message = "Address Book Added Succesfully!";
        }else{
            $message = "Address Book Update Succesfully!";
            AddressBook::find($data['address_id'])->update($data);
        }
        $cart =  Session::get('cart') ? Session::get('cart'):[];
        if(count($cart)){
            return redirect('user/checkout')->with('alert',['messageType'=>'success','message'=>$message]);
        }
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>$message]);
    }
}
