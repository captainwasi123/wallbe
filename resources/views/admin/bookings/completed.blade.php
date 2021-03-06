
@extends('includes.master')
@section('title', 'Completed Bookings')

@section('sidebar')@include('admin.includes.sidebar')@endsection
@section('topbar')@include('admin.includes.topbar')@endsection

@section("content")
<div class="dashboard-wrapper">
    <div class="box-type4">
      <div class="page-title">
         <h3 class="col-white"> Completed Bookings </h3>
         <div class="pull-right" style="margin-top: -46px;">
            <a href="javascript:void(0)" class="btn btn-default" data-href="{{route('admin.completed.export')}}" id="exportCompleteBooking">Export</a>
            <a href="javascript:void(0)" class="btn btn-default color-black" data-href="{{route('admin.completed.export')}}" id="bulkMarkCompleted">Mark as Paid</a>
            <a href="javascript:void(0)" class="btn btn-default color-black" data-href="{{route('admin.completed.export')}}" id="bulkUnmarkCompleted">Unmark as Paid</a>
         </div>
      </div>
      <input type="hidden" id="token" value="{{csrf_token()}}">
      <div class="box-type1">
         <div class="table-overlay table-type1">
            <table>
               <thead>
                  <tr>
                     <th colspan="2"> Date / Time </th>
                     <th> Booking ID </th>
                     <th> Practitioner </th>
                     <th> Booker </th>
                     <th> Marked as Paid </th>
                     <th> Payment Due </th>
                     <th> Charge </th>
                     <th> Actions </th>
                  </tr>
               </thead>
               <tbody>
                   @foreach($data as $val)
                      <tr>
                        <td>
                           <input type="checkbox" name="orderIds" value="{{$val->id}}">
                        </td>
                        <td> 
                           {{date('l, d M Y - h:i A', strtotime($val->start_at.' '.$val->details[0]->start_time))}}
                        </td>
                        <td> #{{$val->id}} </td>
                        <td class="col-blue"> {{empty($val->practitioner) ? 'Deleted User' : $val->practitioner->first_name.' '.$val->practitioner->last_name}}</td>
                        <td class="col-blue"> {{empty($val->booker) ? 'Deleted User' : $val->booker->first_name.' '.$val->booker->last_name}}</td>
                        <td> {{$val->payment_status == '0' ? 'No' : 'Yes'}} </td>
                        <td> {{$val->payment_status == '0' ? '$'.number_format($val->pract_earning, 2) : '$0.0'}} </td>
                        <td> NZ ${{number_format($val->total_amount, 2)}} </td>
                        <td> <a href="javascript:void(0)" class="custom-btn1 orderModal" data-id="{{base64_encode($val->id)}}"> View  </a> </td>
                      </tr>
                   @endforeach
                   @if(count($data) == '0')
                     <tr>
                       <td colspan="6">
                         No Bookings Found.
                       </td>
                     </tr>
                   @endif
               </tbody>
            </table>
         </div>
      </div>
   </div>
 </div>


 <!-- Modal -->
  <div class="modal fade modal-size2 orderView" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog" role="document" style="max-width: 850px;">
         <div class="modal-content">
            <button type="button" class="close1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span></button>
            <div class="booking-modal-popup" id="orderViewContent">
               
            </div>
         </div>
      </div>
   </div>

@endsection
@section('additionalJS')
   <script src="{{URL::to('/')}}/public/assets/js/dev/admin.js"> </script>
   <script type="text/javascript">
      $(document).ready(function(){
         'use strict'

         $(document).on('click', '#exportCompleteBooking', function(){
            let url = $(this).data('href');
            window.location.href = url;
         });
      });
   </script>
@endsection
