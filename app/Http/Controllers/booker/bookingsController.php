<?php

namespace App\Http\Controllers\booker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\orders\order;
use App\Models\MarketplaceSetting;


class bookingsController extends Controller
{
    function index(){
        return view('booker.index');
    }

    function upcomming_booking(){
        $curr = date('Y-m-d H:i:s');
        $data = order::where('booker_id', Auth::id())
                        ->where('start_at', '>=', $curr)
                        ->where('status', '1')
                        ->orderBy('start_at')
                        ->get();

    	return view('booker.booking.upcomming', ['data' => $data]);
    }

    function inprogress_booking(){
        $data = order::where('booker_id', Auth::id())
                        ->where('status', '2')
                        ->orderBy('start_at')
                        ->get();

    	return view('booker.booking.inprogress', ['data' => $data]);
    }

    function completed_booking(){
        $data = order::where('booker_id', Auth::id())
                        ->where('status', '3')
                        ->orderBy('start_at', 'desc')
                        ->get();

    	return view('booker.booking.completed', ['data' => $data]);
    }

    function cancelled_booking(){
        $data = order::where('booker_id', Auth::id())
                        ->where('status', '4')
                        ->orderBy('start_at', 'desc')
                        ->get();

    	return view('booker.booking.cancelled', ['data' => $data]);
    }



    //Response

    function bookingView1($id){
        $id = base64_decode($id);
        $data = order::find($id);

        $gst = MarketplaceSetting::latest()->first();

        return view('booker.booking.response.view', ['data' => $data, 'gst' => $gst->gst]);
    }
}
