<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\services\category;
use App\Models\User;
use App\Models\services\services;

class webController extends Controller
{
    
    function index(){

    	return view('web.index');
    }

    function professionals(){

    	return view('web.professionals');
    }

    function treatments(){
    	$categories = category::where('status', '1')->get();
    	$users = User::where('user_type', '1')->limit(6)->get();

    	return view('web.treatments', ['categories' => $categories, 'users' => $users]);
    }

    function professionalProfile($id){
    	$id = base64_decode($id);
    	$data = User::find($id);
    	$categories = category::where('status', '1')->get();
	    $cat = collect($categories); $cat = $cat->first();
	    $services = services::where('category_id',$cat->id)->where('user_id',$data->id)->get();
    	return view('web.practitionerProfile', ['data' => $data, 'categories' => $categories,'services' => $services]);
    }

	function user_services(Request $request){
		$services = services::where('category_id',$request->cat_id)->where('user_id',$request->userid)->get();
		return view('web.load_practitioner_service', ['services' => $services]);
		
	}
}