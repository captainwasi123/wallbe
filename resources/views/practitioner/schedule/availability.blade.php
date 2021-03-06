@extends('includes.master')
@section('title', 'Your Availability')

@section('sidebar')@include('practitioner.includes.sidebar')@endsection
@section('topbar')@include('practitioner.includes.topbar')@endsection
@section('additionalCSS')
   <link href="{{URL::to('/')}}/public/assets/css/timepicker.css" rel="stylesheet">
   <style type="text/css">
      .mdtp__wrapper[data-theme='blue'] .mdtp__time_holder { 
         background-color: #404780;
      }
      .mdtp__wrapper {
         bottom: 19%!important;
      }
      .mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__am.active, .mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__pm.active {
         background-color: #404780;
      }
      .mdtp__wrapper[data-theme='blue'] .mdtp__digit.active span, .mdtp__wrapper[data-theme='blue'] .mdtp__clock .mdtp__digit span:hover {
         background-color: #404780!important;
      }
      input[type="time"]{
         width: 185px;
      }
   </style>
@endsection
@section('content')
     
<div class="dashboard-wrapper">
   <div class="box-type4">
      <div class="page-title">
         <h3 class="col-white"> Your Availability </h3>
      </div>
      <div class="box-type1">
         <div class="availability-head">
            <h4 class="col-blue"> Opening Hours </h4>
         </div>
         <div class="availability-data">
         <form action="{{route('practitioner.schedule.save')}}" id="scheduleTime" method="post">
            @csrf
               <div class="table-overlay">
                  <table class="availability-table">
                        <tbody>
                           @if(empty($data['sunday']->slots))
                              <tr>
                                 <td> <input type="checkbox" name="is_active[]" value="sunday"> </td>
                                 <td> Sunday </td>
                                 <td> First Booking </td>
                                 <td>
                                    <input type="time" name="days[sunday][0][first_booking]" data-id="sunday-0" class=" startTimeSet" value="09:00" data-day="sunday">
                                 </td>
                                 <td> Last Booking </td> 
                                 <td>
                                    <input type="time" name="days[sunday][0][last_booking]" id="field-sunday-0" class=" endTimeSet" value="17:00"  data-day="sunday">
                                 </td>
                                 <td> 
                                    <a href="javascript:void(0)" data-start="09:00" data-end="17:00" class="col-blue splitShift"  data-id="1" data-day="sunday"> 
                                       + Split Shift 
                                    </a> 
                                 </td>  
                              </tr>
                           @else
                              @php $s=0; @endphp
                              @foreach($data['sunday']->slots as $val)
                                 <tr>
                                    @if($s=='0')
                                       <td> <input type="checkbox" name="is_active[]" value="sunday" checked> </td>
                                       <td> Sunday </td>
                                    @else
                                       <td></td><td></td>
                                    @endif
                                    <td> First Booking </td>
                                    <td>
                                       <input type="time" name="days[sunday][{{$s}}][first_booking]" data-id="" value="{{$val->start_booking}}" class=" startTimeSet"  onchange="validateTime($(this).val(), 'sunday-{{$s}}')" data-day="sunday">
                                    </td>
                                    <td> Last Booking </td>
                                    <td>
                                       <input type="time" name="days[sunday][{{$s}}][last_booking]" value="{{$val->end_booking}}" id="field-sunday-{{$s}}" class="endTimeSet" data-day="sunday">
                                    </td>
                                    @if($s=='0')
                                       <td> 
                                          <a href="javascript:void(0)" data-start="{{$val->start_booking}}" data-end="{{$val->end_booking}}" class="col-blue splitShift"  data-id="1" data-day="sunday"> 
                                             + Split Shift 
                                          </a> 
                                       </td>
                                    @else
                                       <td> 
                                          <a href="javascript:void(0)" class="col-red removeShift"> - Remove </a> 
                                       </td>
                                    @endif
                                 </tr>
                                 @php $s++; @endphp
                              @endforeach
                           @endif
                        </tbody>

                        <tbody>
                           @if(empty($data['monday']->slots))
                              <tr>
                                 <td> <input type="checkbox" name="is_active[]" value="monday"> </td>
                                 <td> Monday </td>
                                 <td> First Booking </td>
                                 <td>
                                    <input type="time" name="days[monday][0][first_booking]" data-id="monday-0" class="" value="09:00"   onchange="validateTime($(this).val(), 'monday-0')">
                                 </td>
                                 <td> Last Booking </td>
                                 <td>
                                    <input type="time" name="days[monday][0][last_booking]" id="field-monday-0" class="" value="17:00">
                                 </td>
                                 <td> 
                                    <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="monday"> 
                                       + Split Shift 
                                    </a> 
                                 </td>  
                              </tr>
                           @else
                              @php $s=0; @endphp
                              @foreach($data['monday']->slots as $val)
                                 <tr>
                                    @if($s=='0')
                                       <td> <input type="checkbox" name="is_active[]" value="monday" checked> </td>
                                       <td> Monday </td>
                                    @else
                                       <td></td><td></td>
                                    @endif
                                    <td> First Booking </td>
                                    <td>
                                       <input type="time" name="days[monday][{{$s}}][first_booking]" data-id="monday-{{$s}}" value="{{$val->start_booking}}" class="">
                                    </td>
                                    <td> Last Booking </td>
                                    <td>
                                       <input type="time" name="days[monday][{{$s}}][last_booking]" id="field-monday-{{$s}}" value="{{$val->end_booking}}" class="">
                                    </td>
                                    @if($s=='0')
                                       <td> 
                                          <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="monday"> 
                                             + Split Shift 
                                          </a> 
                                       </td>
                                    @else
                                       <td> 
                                          <a href="javascript:void(0)" class="col-red removeShift"> - Remove </a> 
                                       </td>
                                    @endif
                                 </tr>
                                 @php $s++; @endphp
                              @endforeach
                           @endif
                        </tbody>


                        <tbody>
                           @if(empty($data['tuesday']->slots))
                              <tr>
                                 <td> <input type="checkbox" name="is_active[]" value="tuesday"> </td>
                                 <td> Tuesday </td>
                                 <td> First Booking </td>
                                 <td>
                                    <input type="time" name="days[tuesday][0][first_booking]" data-id="tuesday-0" class="" value="09:00">
                                 </td>
                                 <td> Last Booking </td>
                                 <td>
                                    <input type="time" name="days[tuesday][0][last_booking]" id="field-tuesday-0" class="" value="17:00">
                                 </td>
                                 <td> 
                                    <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="tuesday"> 
                                       + Split Shift 
                                    </a> 
                                 </td>  
                              </tr>
                           @else
                              @php $s=0; @endphp
                              @foreach($data['tuesday']->slots as $val)
                                 <tr>
                                    @if($s=='0')
                                       <td> <input type="checkbox" name="is_active[]" value="tuesday" checked> </td>
                                       <td> Tuesday </td>
                                    @else
                                       <td></td><td></td>
                                    @endif
                                    <td> First Booking </td>
                                    <td>
                                       <input type="time" name="days[tuesday][{{$s}}][first_booking]" data-id="tuesday-{{$s}}" value="{{$val->start_booking}}" class="">
                                    </td>
                                    <td> Last Booking </td>
                                    <td>
                                       <input type="time" name="days[tuesday][{{$s}}][last_booking]" id="field-tuesday-{{$s}}" value="{{$val->end_booking}}" class="">
                                    </td>
                                    @if($s=='0')
                                       <td> 
                                          <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="tuesday"> 
                                             + Split Shift 
                                          </a> 
                                       </td>
                                    @else
                                       <td> 
                                          <a href="javascript:void(0)" class="col-red removeShift"> - Remove </a> 
                                       </td>
                                    @endif
                                 </tr>
                                 @php $s++; @endphp
                              @endforeach
                           @endif
                        </tbody>


                        <tbody>
                           @if(empty($data['wednesday']->slots))
                              <tr>
                                 <td> <input type="checkbox" name="is_active[]" value="wednesday"> </td>
                                 <td> Wednesday </td>
                                 <td> First Booking </td>
                                 <td>
                                    <input type="time" name="days[wednesday][0][first_booking]" data-id="wednesday-0" class="" value="09:00"  onchange="validateTime($(this).val(), 'wednesday-0')">
                                 </td>
                                 <td> Last Booking </td>
                                 <td>
                                    <input type="time" name="days[wednesday][0][last_booking]" id="field-wednesday-0" class="" value="17:00">
                                 </td>
                                 <td> 
                                    <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="wednesday"> 
                                       + Split Shift 
                                    </a> 
                                 </td>  
                              </tr>
                           @else
                              @php $s=0; @endphp
                              @foreach($data['wednesday']->slots as $val)
                                 <tr>
                                    @if($s=='0')
                                       <td> <input type="checkbox" name="is_active[]" value="wednesday" checked> </td>
                                       <td> Wednesday </td>
                                    @else
                                       <td></td><td></td>
                                    @endif
                                    <td> First Booking </td>
                                    <td>
                                       <input type="time" name="days[wednesday][{{$s}}][first_booking]" data-id="wednesday-{{$s}}" value="{{$val->start_booking}}" class=""  onchange="validateTime($(this).val(), 'wednesday-{{$s}}')">
                                    </td>
                                    <td> Last Booking </td>
                                    <td>
                                       <input type="time" name="days[wednesday][{{$s}}][last_booking]" value="{{$val->end_booking}}" id="field-wednesday-{{$s}}" class="" >
                                    </td>
                                    @if($s=='0')
                                       <td> 
                                          <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="wednesday"> 
                                             + Split Shift 
                                          </a> 
                                       </td>
                                    @else
                                       <td> 
                                          <a href="javascript:void(0)" class="col-red removeShift"> - Remove </a> 
                                       </td>
                                    @endif
                                 </tr>
                                 @php $s++; @endphp
                              @endforeach
                           @endif
                        </tbody>

                        <tbody>
                           @if(empty($data['thursday']->slots))
                              <tr>
                                 <td> <input type="checkbox" name="is_active[]" value="thursday"> </td>
                                 <td> Thursday </td>
                                 <td> First Booking </td>
                                 <td>
                                    <input type="time" name="days[thursday][0][first_booking]" data-id="thursday-0" class="" value="09:00"  onchange="validateTime($(this).val(), 'thursday-0')">
                                 </td>
                                 <td> Last Booking </td>
                                 <td>
                                    <input type="time" name="days[thursday][0][last_booking]" id="field-thursday-0" class="" value="17:00">
                                 </td>
                                 <td> 
                                    <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="thursday"> 
                                       + Split Shift 
                                    </a> 
                                 </td>  
                              </tr>
                           @else
                              @php $s=0; @endphp
                              @foreach($data['thursday']->slots as $val)
                                 <tr>
                                    @if($s=='0')
                                       <td> <input type="checkbox" name="is_active[]" value="thursday" checked> </td>
                                       <td> Thursday </td>
                                    @else
                                       <td></td><td></td>
                                    @endif
                                    <td> First Booking </td>
                                    <td>
                                       <input type="time" name="days[thursday][{{$s}}][first_booking]" value="{{$val->start_booking}}" data-id="thursday-{{$s}}" class=""  onchange="validateTime($(this).val(), 'thursday-{{$s}}')">
                                    </td>
                                    <td> Last Booking </td>
                                    <td>
                                       <input type="time" name="days[thursday][{{$s}}][last_booking]" value="{{$val->end_booking}}" id="field-thursday-{{$s}}" class="">
                                    </td>
                                    @if($s=='0')
                                       <td> 
                                          <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="thursday"> 
                                             + Split Shift 
                                          </a> 
                                       </td>
                                    @else
                                       <td> 
                                          <a href="javascript:void(0)" class="col-red removeShift"> - Remove </a> 
                                       </td>
                                    @endif
                                 </tr>
                                 @php $s++; @endphp
                              @endforeach
                           @endif
                        </tbody>

                        <tbody>
                           @if(empty($data['friday']->slots))
                              <tr>
                                 <td> <input type="checkbox" name="is_active[]" value="friday"> </td>
                                 <td> Friday </td>
                                 <td> First Booking </td>
                                 <td>
                                    <input type="time" name="days[friday][0][first_booking]" data-id="friday-0" class="" value="09:00"  onchange="validateTime($(this).val(), 'friday-0')">
                                 </td>
                                 <td> Last Booking </td>
                                 <td>
                                    <input type="time" name="days[friday][0][last_booking]" id="field-friday-0" class="" value="17:00">
                                 </td>
                                 <td> 
                                    <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="friday"> 
                                       + Split Shift 
                                    </a> 
                                 </td>  
                              </tr>
                           @else
                              @php $s=0; @endphp
                              @foreach($data['friday']->slots as $val)
                                 <tr>
                                    @if($s=='0')
                                       <td> <input type="checkbox" name="is_active[]" value="friday" checked> </td>
                                       <td> Friday </td>
                                    @else
                                       <td></td><td></td>
                                    @endif
                                    <td> First Booking </td>
                                    <td>
                                       <input type="time" name="days[friday][{{$s}}][first_booking]" data-id="friday-{{$s}}" value="{{$val->start_booking}}" class=""  onchange="validateTime($(this).val(), 'friday-{{$s}}')">
                                    </td>
                                    <td> Last Booking </td>
                                    <td>
                                       <input type="time" name="days[friday][{{$s}}][last_booking]" id="field-friday-{{$s}}" value="{{$val->end_booking}}" class="">
                                    </td>
                                    @if($s=='0')
                                       <td> 
                                          <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="friday"> 
                                             + Split Shift 
                                          </a> 
                                       </td>
                                    @else
                                       <td> 
                                          <a href="javascript:void(0)" class="col-red removeShift"> - Remove </a> 
                                       </td>
                                    @endif
                                 </tr>
                                 @php $s++; @endphp
                              @endforeach
                           @endif
                        </tbody>

                        <tbody>
                           @if(empty($data['saturday']->slots))
                              <tr>
                                 <td> <input type="checkbox" name="is_active[]" value="saturday"> </td>
                                 <td> Saturday </td>
                                 <td> First Booking </td>
                                 <td>
                                    <input type="time" name="days[saturday][0][first_booking]" data-id="saturday-0" class="" value="09:00"  onchange="validateTime($(this).val(), 'saturday-0')">
                                 </td>
                                 <td> Last Booking </td>
                                 <td>
                                    <input type="time" name="days[saturday][0][last_booking]" id="field-saturday-0" class="" value="17:00">
                                 </td>
                                 <td> 
                                    <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="saturday"> 
                                       + Split Shift 
                                    </a> 
                                 </td>  
                              </tr>
                           @else
                              @php $s=0; @endphp
                              @foreach($data['saturday']->slots as $val)
                                 <tr>
                                    @if($s=='0')
                                       <td> <input type="checkbox" name="is_active[]" value="saturday" checked> </td>
                                       <td> Saturday </td>
                                    @else
                                       <td></td><td></td>
                                    @endif
                                    <td> First Booking </td>
                                    <td>
                                       <input type="time" name="days[saturday][{{$s}}][first_booking]" data-id="saturday-{{$s}}" value="{{$val->start_booking}}" class=""  onchange="validateTime($(this).val(), 'saturday-{{$s}}')">
                                    </td>
                                    <td> Last Booking </td>
                                    <td>
                                       <input type="time" name="days[saturday][{{$s}}][last_booking]" id="field-saturday-{{$s}}" value="{{$val->end_booking}}" class="">
                                    </td>
                                    @if($s=='0')
                                       <td> 
                                          <a href="javascript:void(0)" class="col-blue splitShift"  data-id="1" data-day="saturday"> 
                                             + Split Shift 
                                          </a> 
                                       </td>
                                    @else
                                       <td> 
                                          <a href="javascript:void(0)" class="col-red removeShift"> - Remove </a> 
                                       </td>
                                    @endif
                                 </tr>
                                 @php $s++; @endphp
                              @endforeach
                           @endif
                        </tbody>
                  </table>
               </div>

               <div class="block-element">
                  <br><br>
                  <div class="availability-head">
                     <h4 class="col-blue"> Dates I Am Closed </h4>
                  </div>
                  <div class="availability-data2 m-b-20">
                     <h5 class="col-black"> Closed on <input type="date" name="close_date" id="close_date"> <a href="javascript:void(0)" class="col-blue addClosed"> +Add </a>  </h5>
                     <div id="close_date_block">
                        @foreach($data['holidays'] as $val)
                           <h5 class="col-black">
                              <input type="date" value="{{$val->closed_date}}" name="closed[]" readonly> 
                              <a href="javascript:void(0)" class="col-blue removeHoliday"> Remove </a> 
                           </h5>
                        @endforeach
                     </div>
                  </div>
                  <div class="block-element text-right mob-text-left availability-data2 m-b-30">
                     <button class="normal-btn rounded bg-blue col-white" type="submit"> Save </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

@endsection
@section('additionalJS')
   <script src="{{URL::to('/')}}/public/assets/js/dev/practitioner.js"> </script>
@endsection