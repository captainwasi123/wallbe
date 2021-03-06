@if($data->status == '4')
   @php
      $pract_percentage = $data->cancel->pract_per;
      $cust_percentage = $data->cancel->cust_per;
      
      $pract_dues = ($data->total_amount/100)*$pract_percentage;
      $cust_dues = ($data->total_amount/100)*$cust_percentage;
   @endphp
@endif

<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12">
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

      <input type="hidden" id="orderId" value="{{base64_encode($data->id)}}">
      <input type="hidden" id="token" value="{{csrf_token()}}">
      <div class="booking-modal-content">
         <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
               <div class="booking-modal-set1">
                  <h6 class="col-grey"> Customer  </h6>
                  <h5 class="col-blue"> {{empty($data->booker) ? 'Deleted User' : $data->booker->first_name.' '.$data->booker->last_name}} </h5>
                  <h6 class="col-grey"> Customer Address  </h6>
                  <h5 class="col-black">
                     {{$data->address}}
                  </h5>

                  @if($data->status == '3')
                  <h6 class="col-grey"> Guest Rating  </h6>
                  <h5 class="col-blue">
                     @if(empty($data->reviews))
                       N/A
                     @else
                       @php $rat = $data->reviews->rating; @endphp
                       <span>
                         @for($i=1; $i<=5; $i++)
                           <i class="fa fa-star {{$i > $rat ? 'star-off' : 'star-onn'}}"> </i>
                         @endfor
                       </span> 
                     @endif
                  </h5>

                  <h6 class="col-grey"> Guest Review  </h6>
                  <h5 class="col-blue">
                     @if(empty($data->reviews))
                       N/A
                     @else
                       {{$data->reviews->review}}
                     @endif
                  </h5>
                  <h6 class="col-grey"> Practitioner Earning  </h6>
                  <h5 class="col-blue"> NZ ${{number_format($data->pract_earning, 2)}} </h5>

                  <h6 class="col-grey ">Refund Amount:
                     <div class="refundBlock defaultRefundBlock">
                        <br>
                        <strong class="col-blue">NZ ${{number_format($data->refund_amount, 2)}}</strong>
                        &nbsp;&nbsp;
                        <a href="javascript:void(0)" class="refundEdit">Edit</a>
                     </div>
                     <div class="refundBlock editRefundBlock" style="display:none; margin-top: 23px;">
                        <form action="{{route('admin.refund.edit')}}" method="post">
                           @csrf
                           <input type="hidden" name="oid" value="{{base64_encode($data->id)}}">
                           <input type="number" class="refundField" step="any" min="0" max="{{$data->total_amount-$data->pract_earning}}" value="{{$data->refund_amount}}" name="refundAmount" required>
                           <button>Save</button>
                        </form>
                     </div>
                  </h6>
                  @endif
                  @if($data->status == '4')
                     <h5 class="border_bottom" style="padding-top: 8px;">Practitioner</h5>
                     <h6 class="col-grey"> Payment :
                        <div class="practAmountBlock defaultPractAmountBlock">
                           <strong class="col-blue">{{$pract_percentage}}%</strong>
                           &nbsp;&nbsp;
                              @if(empty($data->cancel->pract_due))
                                 <a href="javascript:void(0)" class="amountEdit">Edit</a>
                              @endif
                        </div>
                        <div class="practAmountBlock editPractAmountBlock" style="display:none;">
                              <input type="number" class="practAmountField" min="0" max="100" value="{{$pract_percentage}}" id="practAmount" required>
                        </div>
                     </h6>
                     <h6 class="col-grey"> Payment Due: <strong class="col-blue">{{'$'.number_format($pract_dues, 2)}}</strong></h6>
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
                  <h6 class="col-grey "> 
                     <br><br>Commission Rate:
                     <div class="comBlock defaultComBlock">
                        <strong class="col-blue">{{$data->comission}}%</strong>
                        &nbsp;&nbsp;
                        @if($data->payment_status == '0')
                           <a href="javascript:void(0)" class="comEdit">Edit</a>
                        @endif
                     </div>
                     <div class="comBlock editComBlock" style="display:none;">
                        <form action="{{route('admin.comission.edit')}}" method="post">
                           @csrf
                           <input type="hidden" name="oid" value="{{base64_encode($data->id)}}">
                           <input type="number" class="comField" min="0" max="100" value="{{$data->comission}}" name="comission" required>
                           <button>Save</button>
                        </form>
                     </div>
                  </h6>
                  <h6 class="col-grey"> Payment Due: <strong class="col-blue">{{empty($data->paid_status) ? '$'.number_format($data->pract_earning, 2) : '$0.0'}}</strong></h6>
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
                  <h6 class="col-grey refundH"> <br><br>Refund:
                     <div class="custAmountBlock defaultCustAmountBlock">
                        <br><br>
                        <strong class="col-blue">{{$cust_percentage}}%</strong>
                        &nbsp;&nbsp;
                           @if(empty($data->cancel->cust_due))
                              <a href="javascript:void(0)" class="amountEdit">Edit</a>
                           @endif
                     </div>
                     <div class="custAmountBlock editCustAmountBlock" style="display:none;">
                        <br><br>
                        <input type="number" class="custAmountField" min="0" max="100" value="{{$cust_percentage}}" id="custAmount" required>
                        <button type="button" class="saveAmountPercentage">Save</button>
                     </div>
                  </h6>
                  <h6 class="col-grey"> Payment Due: <strong class="col-blue">{{'$'.number_format($cust_dues, 2)}}</strong></h6>
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

                  @case('9')
                     Incomplete
                     @break

               @endswitch
            </strong>
         </p>
      </div>

      <div class="booking-modal-text">
         <p>Booking Instructions:<br>
            <strong>
               {{empty($data->instructions) ? 'N/A' : $data->instructions}}
            </strong>
         </p>
      </div>
   </div>
   <div class="col-md-6">
      <div class="booking-modal-text">
         <h3><br></h3>
         <p>Booking Date:
            <strong>
               {{date('F j, Y, g:i a', strtotime($data->start_at.' '.@$data->details[0]->start_time))}}
            </strong>
         </p>
         @if($data->status == '4')
           <p>Cancellation Date:
            <strong>
               {{date('F j, Y, g:i a', strtotime(@$data->cancel->created_at))}}
            </strong>
         </p>
            <p>Cancellation Reason:
               <text>
               {{@$data->cancel->reason}}
               </text>
         </p>
         @endif
      </div>
   </div>
   @foreach($data->details as $val)
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
         <div class="booking-detail-table">
            <table>
               <tbody>
                  <tr>
                     <td> 
                        <label>Start Time</label>  {{date('h:i A', strtotime($val->start_time))}} 
                     </td>
                     <td> 
                        <label>End Time</label>  {{date('h:i A', strtotime($val->end_time))}} 
                     </td>
                  </tr>
                  @php 
                     $timeFirst  = strtotime($val->start_time);
                     $timeSecond = strtotime($val->end_time);
                     $differenceInSeconds = $timeSecond - $timeFirst;
                     $duration = $differenceInSeconds/60;
                  @endphp
                  <tr>
                     <td class="wd-40" colspan="2"> 
                        <label>Product Name</label>{{$val->service->name}} 
                        <small>{{$duration}} Mins</small> 
                     </td>
                     <td> <label>Quantity</label> {{$val->qty}}x </td>
                     <td> <label>Price</label> NZ ${{number_format($val->price, 2)}} </td>
                  </tr>
                  <tr>
                     <td class="wd-40" colspan="4"> 
                        <label>Addons</label>
                        @foreach($val->addons as $ad)
                           <div class="addonLabel">
                              <span>{{empty($ad->addon->name) ? 'Deleted Addon' : $ad->addon->name}}</span><br>
                              <span></span>
                              <span>${{$ad->price}}</span>
                           </div> 
                        @endforeach
                        @if(count($val->addons) == 0)
                           N/A
                        @endif
                     </td>
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
