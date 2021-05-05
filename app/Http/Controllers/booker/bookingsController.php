<?php

namespace App\Http\Controllers\booker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\orders\order;
use App\Models\orders\cancel;
use App\Models\orders\reviews;
use App\Models\MarketplaceSetting;


class bookingsController extends Controller
{
    function index(){
        $curr = date('Y-m-d H:i:s');
        $upcomming = order::where('booker_id', Auth::id())
                        ->where('start_at', '>=', $curr)
                        ->where('status', '1')
                        ->orderBy('start_at')
                        ->limit(12)
                        ->get();

        $rating = order::where('booker_id', Auth::id())
                        ->where('status', '3')
                        ->orderBy('start_at', 'desc')
                        ->doesnthave('reviews')
                        ->limit(7)
                        ->get();

        return view('booker.index', ['upcomming' => $upcomming, 'rating' => $rating]);
    }

    function bookOrder(Request $request){
        $data = $request->all();
        order::makeOrder($data);
        session()->forget('cart');
        return redirect()->back()->with('success', 'Order Confirmed.');
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


    //Cancel

    function bookingCancel(Request $request){
        $data = $request->all();
        $id = base64_decode(base64_decode($data['oid']));
        $des = $data['description'];

        cancel::cancellation($id, $des, '1');

        return redirect()->back()->with('success', 'Order Cancelled.');
    }


    //Rating

    function bookingRating(Request $request){
        $data = $request->all();
        $id = base64_decode($data['ref_id']);
        $prac = order::where('id', $id)->select('pract_id')->first();
        reviews::addReview($prac->pract_id, $data);
        
        return redirect()->back()->with('success', 'Review Added.');

    }
}
