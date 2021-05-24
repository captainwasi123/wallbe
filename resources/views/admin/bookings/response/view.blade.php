@if($data->status == '4')
   @php
      $pract_percentage = 0;
      $cust_percentage = 0;
      $pract_dues = 0;
      $cust_dues = 0;

      if($data->pract_id == $data->cancel->user_id){
         $pract_percentage = 0;
         $cust_percentage = 100;
      }else{
         $timestamp1 = strtotime($data->start_at.' '.$data->details[0]->start_time);
         $timestamp2 = strtotime($data->cancel->created_at);
         $hours_gap = abs($timestamp2 - $timestamp1)/(60*60);
         
         if($hours_gap > 24){
            $pract_percentage = 0;
            $cust_percentage = 100;
         }elseif($hours_gap > 2 && $hours_gap <= 24){
            $pract_percentage = 0;
            $cust_percentage = 75;
         }elseif($hours_gap < 2){
            $pract_percentage = 75;
            $cust_percentage = 0;
         }  
      }

      $pract_dues = ($data->pract_earning/100)*$pract_percentage;
      $cust_dues = ($data->total_amount/100)*$cust_percentage;
   @endphp
@endif
<div class="booking-modal-head">
   <div class="row">
      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
         <div class="booking-modal-text">
            <h3> Booking Information: #{{$data->id}} </h3>
         </div>
      </div>
      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
         <div class="booking-modal-text text-right">
            <h3> Total Amount  <b class="col-blue"> NZ ${{number_format($data->total_amount, 2)}} </b> </h3>
         </div>
      </div>
   </div>
</div>
<div class="booking-modal-content">
   <div class="row">
      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
         <div class="booking-modal-set1">
            <h6 class="col-grey"> Customer  </h6>
            <h5 class="col-blue"> {{empty($data->booker) ? 'Deleted User' : $data->booker->first_name.' '.$data->booker->last_name}} </h5>
            <h6 class="col-grey"> Customer Address  </h6>
            <h5 class="col-black">
               {{empty($data->booker->user_address) ? '' : $data->booker->user_address->postcode.' - '}}
               {{empty($data->booker->user_address) ? '' : $data->booker->user_address->street.', '}}
               {{empty($data->booker->user_address) ? '' : $data->booker->user_address->city.', '}}
               {{empty($data->booker->user_address) ? '' : $data->booker->user_address->state.', '}}
               {{empty($data->booker->user_address->country) ? '' : $data->booker->user_address->country->country}}
            </h5>

            @if($data->status == '3')
               <h6 class="col-grey"> Guest Rating  </h6>
               <h5 class="col-blue"> - </h5>
               <h6 class="col-grey"> Guest Review  </h6>
               <h5 class="col-blue"> - </h5>

               <h6 class="col-grey"> Practitioner Earning  </h6>
               <h5 class="col-blue"> NZ ${{number_format($data->pract_earning, 2)}} </h5>
            @endif
            @if($data->status == '4')
               <h5 class="border_bottom" style="padding-top: 8px;">Practitioner</h5>
               <h6 class="col-grey"> Refund: <strong class="col-blue">{{$pract_percentage}}%</strong></h6>
               <h6 class="col-grey"> Payment Due: <strong class="col-blue">{{empty($data->cancel->pract_due) ? '$'.number_format($pract_dues, 2) : '$0.0'}}</strong></h6>
               <h6 class="col-grey"> Payout Bank: <strong class="col-blue">{{empty($data->practitioner->users_payout_details) ? 'NA' : $data->practitioner->users_payout_details->bank_account_name}}</strong></h6>
               <h6 class="col-grey"> Account Number:  </h6>
               <h5 class="col-blue"> {{empty($data->practitioner->users_payout_details) ? 'NA' : $data->practitioner->users_payout_details->bank_account_number}}</h5>
               
               @if($pract_percentage > 0)
                  @if(empty($data->cancel->pract_due))
                     <div class="block-element text-right">
                        <a href="javascript:void(0)" class="normal-btn bg-blue col-white rounded pract_markasPaid" data-ref="{{base64_encode($data->cancel->id)}}"> Mark as Paid </a>
                     </div>
                  @else
                     <div class="block-element text-right">
                        <a href="javascript:void(0)" class="normal-btn bg-red col-white rounded pract_unmarkasPaid" data-ref="{{base64_encode($data->cancel->id)}}"> Unmark as Paid </a>
                     </div>
                  @endif
               @endif
            @endif
         </div>
      </div>
      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
         <div class="booking-modal-set2" style="margin-bottom: 20px;">
            <table>
               <tbody>
                  <tr>
                     <td> Subtotal:  </td>
                     <td> NZ ${{number_format($data->sub_total, 2)}} </td>
                  </tr>
                  <tr>
                     <td> GST - {{$gst}}% </td>
                     <td> NZ ${{number_format($data->gst, 2)}} </td>
                  </tr>
               </tbody>
               <tfoot>
                  <tr>
                     <td> <b> Total Amount </b> </td>
                     <td> <b class="col-blue"> NZ ${{number_format($data->total_amount, 2)}} </b> </td>
                  </tr>
               </tfoot>
            </table>
         </div>

         @if($data->status == '3')
            <h6 class="col-grey"> <br><br>Payment Due: <strong class="col-blue">{{empty($data->paid_status) ? '$'.number_format($data->pract_earning, 2) : '$0.0'}}</strong></h6>
            <h6 class="col-grey"> Payout Bank: <strong class="col-blue">{{empty($data->practitioner->users_payout_details) ? 'NA' : $data->practitioner->users_payout_details->bank_account_name}}</strong></h6>
            <h6 class="col-grey"> Account Number:  </h6>
            <h5 class="col-blue"> {{empty($data->practitioner->users_payout_details) ? 'NA' : $data->practitioner->users_payout_details->bank_account_number}}</h5>
            @if($data->payment_status == '0')
               <div class="block-element text-right">
                  <a href="javascript:void(0)" class="normal-btn bg-blue col-white rounded markasPaid" data-ref="{{base64_encode(base64_encode($data->id))}}"> Mark as Paid </a>
               </div>
            @else
               <div class="block-element text-right">
                  <a href="javascript:void(0)" class="normal-btn bg-red col-white rounded unmarkasPaid" data-ref="{{base64_encode(base64_encode($data->id))}}"> Unmark as Paid </a>
               </div>
            @endif
         @elseif($data->status == '4')
            <h5 class="border_bottom">Customer</h5>
               <h6 class="col-grey"> <br><br>Refund: <strong class="col-blue">{{$cust_percentage}}%</strong></h6>
            <h6 class="col-grey"> Payment Due: <strong class="col-blue">{{empty($data->cancel->cust_due) ? '$'.number_format($cust_dues, 2) : '$0.0'}}</strong></h6>
            <br>
            @if($cust_percentage > 0)
               @if(empty($data->cancel->cust_due))
                  <div class="block-element text-right">
                     <a href="javascript:void(0)" class="normal-btn bg-blue col-white rounded cust_markasPaid" data-ref="{{base64_encode($data->cancel->id)}}"> Mark as Paid </a>
                  </div>
               @else
                  <div class="block-element text-right">
                     <a href="javascript:void(0)" class="normal-btn bg-red col-white rounded cust_unmarkasPaid" data-ref="{{base64_encode($data->cancel->id)}}"> Unmark as Paid </a>
                  </div>
               @endif
            @endif
         @endif
      </div>
   </div>
</div>
<div class="row">
   <div class="col-md-6">
      <div class="booking-modal-text">
         <h3> Details </h3>
         <p>Booking Status: 
            <strong>
               @switch($data->status)
                  @case('1')
                     Upcoming
                     @break

                  @case('2')
                     In-Progress
                     @break

                  @case('3')
                     Completed
                     @break

                  @case('4')
                     Cancelled
                     @break

               @endswitch
            </strong>
         </p>
      </div>
   </div>
   <div class="col-md-6">
      <div class="booking-modal-text">
         <h3><br></h3>
         <p>Booking Date:
            <strong>
               {{date('d-M-Y', strtotime($data->start_at))}}
            </strong>
         </p>
      </div>
   </div>
   @foreach($data->details as $val)    
      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
         <div class="booking-detail-table">
            <table>
               <tbody>
                  <tr>
                     <td class="wd-40"> Product Name </td>
                     <td class="wd-60"> {{$val->service->name}}<br>{{$val->service->duration}} Mins </td>
                  </tr>
                  <tr>
                     <td class="wd-40"> Price: </td>
                     <td class="wd-60"> NZ ${{number_format($val->price, 2)}} </td>
                  </tr>
                  <tr>
                     <td class="wd-40"> Start Time: </td>
                     <td class="wd-60"> {{date('h:i A', strtotime($val->start_time))}} </td>
                  </tr>
                  <tr>
                     <td class="wd-40"> End Time: </td>
                     <td class="wd-60"> {{date('h:i A', strtotime($val->end_time))}} </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   @endforeach
</div>
@if($data->status == '1' || $data->status == '2')
   <div class="block-element text-right">
      <a href="javascript:void(0)" class="normal-btn bg-blue col-white rounded orderCancel" data-ref="{{base64_encode(base64_encode($data->id))}}"> Cancel Booking </a>
   </div>
@endif 