<?php

namespace App\Http\Controllers\booker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Country;
use App\Models\UserAddress;

class profileController extends Controller
{
    function index(){
        $data = array(
            'user_data' => User::with(['user_address','user_store','users_payout_details'])->where('id',auth()->user()->id)->first(),
            'country_data' => Country::latest()->get(),
        );
    	return view('booker.profile.general')->with($data);
    }

    public function profile_save(Request $request)
    { 
        $user = User::where('id',$request->user_id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->newsletter = (isset($request->newsletter)) ? '1' : '0';
        $user->save();
        $check_address = UserAddress::where('user_id',$request->user_id)->first();
        
        if(!empty($check_address)){
            $address = $check_address;
        }else{ 
            $address = new UserAddress(); 
        }
        $address->user_id = $request->user_id;
        $address->street = $request->street;
        $address->suburb = $request->suburb;
        $address->city = $request->city;
        $address->postcode = $request->postcode;
        $address->state = $request->state;
        $address->country_id = $request->country;
        $address->save();

        return redirect()->route('booker.profile')->with('success',"Profile Updated Successfully");
    }
}

