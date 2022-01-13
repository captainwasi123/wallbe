@extends('web.new.includes.master')
@section('title', 'Select Professional')
@section('content')
@php $totalAmount = 0; @endphp

<section class="pad-top-40 pad-bot-40 bg-pink">
   <div class="container">
      <div class="breadcrumb-custom2 m-b-40">
         <a data-toggle="modal" data-target=".editBookingModal"> <i class="fa fa-angle-left"> </i> Select professional </a>
      </div>
      

   

      <div class="block-element">
         <div class="row">
            <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 sec-wid-left">
               <div class="booking-details-wrapper m-b-30" style="background:#fcfcfc !important">
                  <div class="calendar-booking">
                     <div class="calendar-booking-head">
                        <h3> Schedule </h3>
                     </div>
                     <div class="calendar-book">
                        <div class="date-picker">
                           <div class="input">
                              <div class="result"><span></span></div>
                              <button><i class="fa fa-calendar"></i></button>
                           </div>
                           <div class="calendar"></div>
                        </div>
                     </div>
                  </div>
                  @php $duration = 0; $bslot = 30; @endphp
                  @if(Session::get('cart') !== null)
                     @foreach(Session::get('cart.services') as $val)
                        @php $duration = $duration+($val['duration']*$val['quantity']); @endphp
                     @endforeach
                     @if(count(Session::get('cart')) == 0)
                        @php $duration = 30; @endphp
                     @endif
                  @else
                     @php $duration = 30; @endphp
                  @endif
                  <div id="professionalBlock">
                     <div class="bookings-trigger">
                        <ul class="nav nav-tabs no-border" role="tablist">
                           <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"> Practitioners </a>
                           </li>
                        </ul>
                     </div>
                     <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                           <div class="all-bookings">
                              @foreach($users as $val)
                                 <div class="booking-practices">
                                    <div class="booking-details-person">
                                       <img src="{{URL::to('/')}}/{{$val->profile_img}}" onerror="this.onerror=null;this.src='{{URL::to('/')}}/public/assets/images/user-placeholder.png';">
                                       <h5> {{$val->first_name.' '.$val->last_name}} </h5>
                                       <p> 
                                          <a href="javascript:void(0)" class="viewUserProfile" data-id="{{base64_encode($val->id)}}"> View Profile </a> 

                                          <b class="col-grey font-thin"> 
                                             <i class="fa fa-star col-yellow"> </i> 
                                             {{empty($val->avgRating) ? '0.0' : number_format($val->avgRating[0]->aggregate, 1)}} 
                                          </b> 
                                       </p>
                                    </div>
                                    <div class="booking-persons-time time-slider arrows">
                                       @foreach($val->availability as $avail)
                                          @if(ucfirst($avail->week_day) == $day)
                                             @foreach($avail->slots as $slot)
                                                @php
                                                   $x = 0; 
                                                   $buffer = empty($val->user_store->buffer_between_appointments) ? 30 : $val->user_store->buffer_between_appointments; 
                                                   if($date == date('Y-m-d')){
                                                      $curr = date('H:i:s');
                                                      if($curr > $slot->start_booking){
                                                         $curr = date('H:i:s',strtotime('+1 hour',strtotime($curr)));
                                                         $curr = date('H',strtotime($curr));
                                                         $curr = $curr.':00:00';
                                                         $start = $curr;
                                                      }else{
                                                         $start = $slot->start_booking;
                                                      }
                                                   }else{
                                                      $start = $slot->start_booking;
                                                   } 
                                                   $end = $slot->end_booking; 
                                                   $end = date('H:i:s',strtotime($end));
                                                @endphp
                                                @php $bookingDuration = $duration+$buffer; @endphp
                                                @while($start <= $end)
                                                   @php $v = 1; @endphp
                                                   @foreach($val->p_upcoming as $vup)
                                                      @if($vup->start_at == date('Y-m-d'))
                                                         @foreach($vup->details as $vupd)
                                                            @if($start >= $vupd->start_time && $start <= $vupd->end_time)
                                                               @php $v = 0; @endphp
                                                            @endif
                                                            
                                                            @php 
                                                               $endDuration = date('H:i:s',strtotime('+'.$bookingDuration.' minutes',strtotime($start))); 
                                                               $endDuration2 = date('H:i:s',strtotime('+'.$buffer.' minutes',strtotime($vupd->end_time))); 
                                                            @endphp

                                                            @if($endDuration >= $vupd->start_time && $endDuration <= $endDuration2)
                                                               @php $v = 0; @endphp
                                                            @endif
                                                         @endforeach
                                                      @endif
                                                   @endforeach
                                                   @php 
                                                      $endDuration = date('H:i:s',strtotime('+'.$bookingDuration.' minutes',strtotime($start)));
                                                   @endphp
                                                   @if($endDuration >= $end)
                                                      @php $v = 0; @endphp
                                                   @endif
                                                   @if($v == 1)
                                                   <div>
                                                      <input type="radio" id="myCheck{{$slot->id.$x}}" class="timeslot" name="timeslot" data-time="{{date('h:i A', strtotime($start))}}" data-prac="{{base64_encode($val->id)}}" tabindex="-1"> 
                                                      <label class="book-time-btn"  for="myCheck{{$slot->id.$x}}" >{{date('h:i A', strtotime($start))}}</label>
                                                   </div>
                                                   @endif
                                                   @php $start = date('H:i:s',strtotime('+'.$bslot.' minutes',strtotime($start))); $x++; @endphp
                                                @endwhile 
                                             @endforeach
                                          @endif
                                       @endforeach
                                    </div>
                                   
                                 </div>
                                 
                              @endforeach
                              @if(count($users) == 0)
                                 <div class="empty-bookings">
                                    <img src="{{URL::to('/public/assets/web/new')}}/images/empty-booking.jpg">
                                    <h4> Sorry, we dont have anybody available to fulfill this order. Try another date. </h4>
                                    <p> Tip: If your order contains seperate types of treatments, you may need to split these out as many of our therapist are specialists. </p>
                                 </div>
                              @endif
                           </div>
                        </div>
                        <!-- <div class="tab-pane" id="tabs-2" role="tabpanel">
                           <div class="empty-bookings">
                              <img src="{{URL::to('/public/assets/web/new')}}/images/empty-booking.jpg">
                              <h4> Sorry, we dont have anybody available to fulfill this order. Try another date. </h4>
                              <p> Tip: If your order contains seperate types of treatments, you may need to split these out as many of our therapist are specialists. </p>
                           </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                           <div class="empty-bookings">
                              <img src="{{URL::to('/public/assets/web/new')}}/images/empty-booking.jpg">
                              <h4> Sorry, we dont have anybody available to fulfill this order. Try another date. </h4>
                              <p> Tip: If your order contains seperate types of treatments, you may need to split these out as many of our therapist are specialists. </p>
                           </div>
                        </div>
                        <div class="tab-pane" id="tabs-4" role="tabpanel">
                           <div class="empty-bookings">
                              <img src="{{URL::to('/public/assets/web/new')}}/images/empty-booking.jpg">
                              <h4> Sorry, we dont have anybody available to fulfill this order. Try another date. </h4>
                              <p> Tip: If your order contains seperate types of treatments, you may need to split these out as many of our therapist are specialists. </p>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 sec-wid-right">
               <div class="summary-box2" style="background:#fcfcfc !important" id="step1Summary">
                  <div class="book-summary-head">
                     <h3 class="text-center"> Summary  </h3>
                  </div>
                  <div class="book-summary-item">
                     <h6> <img src="{{URL::to('/public/assets/web/new')}}/images/map-icon1.jpg"> {{Session::get('cart.location.place')}} </h6>
                  </div>
                  @if(Session::get('cart') !== null)
                     @foreach(Session::get('cart.services') as $val)
                        <div class="book-summary-item">
                           <h5>{{$val['quantity']}}x {{$val['title']}} </h5>
                           @php $addonPrice = 0;$addonDuration = 0; @endphp
                           @if(count($val['addons']) > 0)
                              <p class="addonLabelTreatment">
                                 Includes
                                 @foreach($val['addons'] as $key => $adval)
                                    {{$key == 0 ? '' : ', '}}{{$adval['name']}}
                                    @php $addonPrice = $addonPrice+$adval['price']; @endphp
                                    @php $addonDuration = $addonDuration+$adval['duration']; @endphp
                                 @endforeach
                              </p>
                           @endif
                           <p> <b class="col-green"> 
                           </b> {{$val['duration']+$addonDuration}} minutes </p>
                        </div>
                        @php $totalAmount = $totalAmount+(($val['price']+$addonPrice)*$val['quantity']); @endphp
                     @endforeach
                     @if(count(Session::get('cart')) == 0)
                        <h4>No Items Found.</h4>
                     @endif
                  @else
                     <h4>No Items Found.</h4>
                  @endif
                  <div class="booking-details-item m-t-20">
                     <h6> <img src="{{URL::to('/public/assets/web/new')}}/images/booking-icon1.jpg"> Date & Time </h6>
                     <h5> <span id="bookingDate">{{date('d-m-Y', strtotime($date))}}</span> - <span id="bookingTime"></span> </h5>
                  </div>
                  @php 
                     $gst = $marketplace_data->gst;
                     $gst_amount = ($totalAmount/100)*$gst;
                  @endphp
                  <div class="book-summary-instructions m-t-50">
                     <h6> Total <b> ${{number_format($totalAmount+$gst_amount, 2)}} <small>inc GST</small> </b> </h6>
                  </div>
                  <div class="block-element">
                     <div class="row m-t-20 m-b-10">
                        <form method="post" action="{{route('treatments.booking.step2')}}">
                           @csrf
                           <input type="hidden" name="booking_date" id="booking_date" value="{{date('d-m-Y', strtotime($date))}}">
                           <input type="hidden" name="booking_time" id="booking_time" value="">
                           <input type="hidden" name="booking_prac" id="booking_prac" value="">
                           @if(Auth::check())
                              <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                 <button type="button" class="submit-btn1 block-element1" id="checkout_btn" style="padding-left: 50px;padding-right: 50px;"> Continue to Checkout </button>
                              </div>
                           @else
                              <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
                                 <a href="javascript:void(0)" class="submit-btn1 block-element1" style="padding-left: 50px;padding-right: 50px;" data-toggle="modal" data-target=".loginAuthModal"> Continue to Checkout </a>
                              </div>
                           @endif
                        </form>
                     </div>
                  </div>
                  <div class="order-information">
                     <p> Your order must be a minimum of $25 for our mobile treatments </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
     
   </div>
</section>


<div class="modal popup-1 fade editBookingModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
   <div class="modal-dialog modal-lg" role="document" style="max-width: 550px;">
      <div class="modal-content">
         <div class="rounded-1 bg-white  ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div class="card-form block-element text-center">
               <div class="block-element card-form-head m-b-20 m-t-10">
                  <h2 class="text-left"> Are you sure?  </h2>
                  <p class="text-left"> This will take you back to edit your booking details </p>
               </div>
               <div class="block-element">
                  <div class="row m-b-10">
                     <div class="col-md-12">
                        <p>   <a href="javascript:history.back()" class="custom-anchor1 text-center" style="min-width: 230px;"> Edit My Booking </a> </p>
                        <p>  <a data-dismiss="modal" aria-label="Close" class="custom-anchor2 text-center no-border" style="min-width: 230px;"> <b> Cancel </b> </a> </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal popup-1 fade userProfileModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
   <div class="modal-dialog modal-lg" role="document" style="max-width: 600px;">
      <div class="modal-content">
         <div class="rounded-1 bg-white">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div class="feder-profile" id="userProfileModalBody">
               
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal popup-1 fade loginAuthModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
   <div class="modal-dialog modal-lg" role="document" style="max-width: 550px;">
      <div class="modal-content">
         <div class="rounded-1 bg-white  ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div class="card-form block-element text-center">
               <div class="block-element card-form-head m-b-20 m-t-10">
                  <h2 class="text-left">
                  Login or Sign up  </h2>
                  <p class="text-left"> You need to login or create a new account to continue with the booking process </p>
               </div>
               <div class="block-element">
                  <div class="row m-b-10">
                     <div class="col-md-12">
                        <p>   <a href="{{URL::to('/login')}}" class="custom-anchor1 text-center" style="min-width: 230px;"> Login </a> </p>
                        <p>  <a href="{{URL::to('/register')}}" class="custom-anchor2 text-center no-border" style="min-width: 230px;"> <b> Create Account </b> </a> </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@section('addScript')
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
@endsection