@extends('includes.master')
@section('title', 'General')

@section('sidebar')@include('practitioner.includes.sidebar')@endsection
@section('topbar')@include('practitioner.includes.topbar')@endsection

@section('content')
     
<div class="dashboard-wrapper">
   <form action="{{route('practitioner.profile.save')}}" method="post" enctype='multipart/form-data'>
   @csrf
   <input type="hidden" name="user_id" value="{{$user_data->id}}">
   <div class="box-type4">
      <div class="page-title">
         <h3 class="col-white"> General </h3>
      </div>
   <div class="block-element pad-1">
      <div class="row">
         <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
            <div class="block-element m-t-15 m-b-10">
               <h4 class="col-blue"> General </h4>
            </div>
            <div class="row">
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> First Name/display name </p>
                     <input type="text"  name="first_name" value="{{$user_data->first_name}}">
                  </div>
               </div>   
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Last name </p>
                     <input type="text"  name="last_name" value="{{$user_data->last_name}}">
                  </div>
               </div>   
               <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Email </p>
                     <input type="email"  name="email" value="{{$user_data->email}}" readonly>
                  </div>
               </div>   
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Phone </p>
                     <input type="text"  name="phone" value="{{$user_data->phone}}">
                  </div>
               </div>   
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Gender </p>
                     <select name="gender">
                        <option value="male" {{ isset($user_data) && 'male' == @$user_data->gender ? 'selected' : ''}}> Male </option>
                        <option value="female" {{ isset($user_data) && 'female' == @$user_data->gender ? 'selected' : ''}}> Female </option>
                        <option value="other" {{ isset($user_data) && 'other' == @$user_data->gender ? 'selected' : ''}}> Other </option>
                     </select>
                  </div>
               </div>   
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Bio/Your Experience </p>
                     <input type="text"  name="bio" value="{{$user_data->bio_description}}">
                  </div>
               </div>   
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3 m-t-20">
                     <p> Profile Photo <input type="file" name="profile_img" class="bg-blue normal-btn col-white pad-1 rounded"></p>
                  </div>
               </div>   
            </div>

            <div class="block-element">
               <h4 class="col-blue"> Address </h4>
            </div>
            <div class="row m-b-20">
               <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Street </p>
                     <textarea name="street">{{$user_data->user_address->street}}</textarea>
                  </div>
               </div>   
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Suburb </p>
                     <input type="text" name="suburb" value="{{$user_data->user_address->suburb}}">
                  </div>
               </div>   
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> City </p>
                     <input type="text" name="city" value="{{$user_data->user_address->city}}">
                  </div>
               </div>   
               <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Post code </p>
                     <input type="text" name="postcode" value="{{$user_data->user_address->postcode}}">
                  </div>
               </div>   
               <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> State </p>
                     <input type="text" name="state" value="{{$user_data->user_address->state}}">
                  </div>
               </div>      
               <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                  <div class="form-field3">
                     <p> Country </p>
                     <select name="country" id="">
                        <option value="">select...</option>
                        @foreach($country_data as $country_data)
                         <option value="{{$country_data->id}}" {{ isset($user_data) && $country_data->id == @$user_data->user_address->country_id ? 'selected' : ''}}>{{$country_data->country}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>   
            </div>
         </div>
         <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
            <div class="block-element m-t-15 m-b-10" style="position: relative;">
               <h4 class="col-blue"> Store </h4>
               <div class="store-status">
                  <span> Status: <b class="col-red"> Awaiting Approval </b> </span>
               </div>
            </div>
            <div class="form-field3">
               <p> Where do you offer services? </p>
               <div class="drop-options">
                  <span> <input type="radio" name="offer_services" value="mobile" {{ isset($user_data) && 'mobile' == @$user_data->user_store->offer_services ? 'checked' : ''}}> Mobile </span>
                  <span> <input type="radio" name="offer_services" value="my_address" {{ isset($user_data) && 'my_address' == @$user_data->user_store->offer_services ? 'checked' : ''}}> My Address </span>
                  <span> <input type="radio" name="offer_services" value="both" {{ isset($user_data) && 'both' == @$user_data->user_store->offer_services ? 'checked' : ''}}> Both  </span>
               </div>
            </div>
            <div class="form-field3">
               <p> Service Radius <button class="bg-blue normal-btn pad-1 col-white rounded"> Set Service Radius </button>  </p>
            </div>
            <div class="form-field3">
               <p> Minimum Booking Amount </p>
               <input type="text" name="minimum_booking_amount" value="{{$user_data->user_store->minimum_booking_amount}}" style="padding-left: 25px;">
               <b class="info-tag1 col-blue" style="display: inline-block; width: 20px; margin-top: -28px; vertical-align: top; margin-left: 8px;"> $ </b>
            </div>
            <div class="form-field3">
               <p> buffer Between Appointments </p>
               <input type="text" name="buffer_between_appointments" value="{{$user_data->user_store->buffer_between_appointments}}">
            </div>
            <div class="block-element m-t-15 m-b-10">
               <h4 class="col-blue"> Payout Details </h4>
            </div>
            <div class="form-field3">
               <p>  Bank Account Name  </p>
               <input type="text" name="bank_name" value="{{$user_data->users_payout_details->bank_account_name}}">
            </div>
            <div class="form-field3">
               <p> Bank Account Number </p>
               <input type="text" name="account_number" value="{{$user_data->users_payout_details->bank_account_number}}">
            </div>
            <div class="bg-silver block-element m-t-20 m-b-20" style="padding:20px">
               <div class="form-field3">
                  <p> Store Page </p>
                  <div class="drop-options">
                     <span> <input type="radio" name=""> Disabled </span>
                     <span> <input type="radio" name=""> Enabled </span>
                  </div>
               </div>
               <div class="form-field3">
                  <p> Marketplace Comission </p>
                  <input type="text" name="">
               </div>
               <div class="form-field3">
                  <p> Account Type  </p>
                  <div class="drop-options">
                     <span> <input type="radio" name=""> Standard </span>
                     <span> <input type="radio" name=""> Featured </span>
                     <span> <input type="radio" name=""> Partner </span>
                  </div>
               </div>
            </div>
         </div>   
      </div>   
   </div>
</div>




<div class="box-type4">
   <div class="page-title m-b-25">
      <h3 class="col-white"> Security </h3>
   </div>
   <div class="block-element pad-1 m-b-15">
      <button class="bg-blue col-white normal-btn rounded"> Request Password Reset  </button>
   </div>
   <div class="block-element pad-1 m-b-20">
      <button class="bg-blue col-white normal-btn rounded"> Delete Account </button>
   </div>
   <div class="block-element text-right mob-text-left pad-1 m-b-20">
      <button class="bg-blue col-white normal-btn rounded" type="submit"> Save  </button>
   </div>
</div>
</form>
@endsection