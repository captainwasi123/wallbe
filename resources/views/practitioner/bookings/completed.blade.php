@extends('includes.master')
@section('title', 'Completed Bookings')

@section('sidebar')@include('practitioner.includes.sidebar')@endsection
@section('topbar')@include('practitioner.includes.topbar')@endsection

@section('content')

    <div class="dashboard-wrapper">
      <div class="box-type4">
        <div class="page-title">
           <h3 class="col-white"> Completed Bookings </h3>
        </div>
        <div class="box-type1">
           <div class="table-overlay table-type1">
              <table>
                 <thead>
                    <tr>
                       <th> Date / Time </th>
                       <th> Booking ID </th>
                       <th> Booker </th>
                       <th> Payment Status </th>
                       <th> My Earnings </th>
                       <th> Actions </th>
                    </tr>
                 </thead>
                 <tbody>
                    @foreach($data as $val)
                      <tr>
                         <td> {{date('l, d M Y - h:i A', strtotime($val->start_at))}}</td>
                         <td> #{{$val->id}} </td>
                         <td class="col-blue"> {{empty($val->booker) ? 'Deleted User' : $val->booker->first_name.' '.$val->booker->last_name}} <i class="fa fa-comments col-black"> </i> </td>
                         <td>-</td>
                         <td> NZ ${{number_format($val->pract_earning, 2)}} </td>
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
               <button type="button" class="close1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
               <div class="booking-modal-popup" id="orderViewContent">
                  
               </div>
            </div>
         </div>
      </div>

@endsection
@section('additionalJS')
   <script src="{{URL::to('/')}}/public/assets/js/dev/practitioner.js"> </script>
@endsection
