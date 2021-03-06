<form method="post" action="{{route('admin.services.update')}}">
   {{csrf_field()}}
   <input type="hidden" name="service_id" value="{{base64_encode($data->id)}}">
   <div class="form-field2">
      <p> SERVICE NAME <sup class="col-red">*</sup> </p>
      <input type="text" placeholder="Please enter name" name="service_name" value="{{$data->name}}" required="">
   </div>
   <div class="form-field2">
      <p> SERVICE DURATION (IN MINUTES) <sup class="col-red">*</sup> </p>
      <input type="number" placeholder="0" name="duration" value="{{$data->duration}}" required="">
   </div>
   <div class="form-field2">
      <p> PRICE (EXCL GST) <sup class="col-red">*</sup> </p>
      <input type="number" step="any" placeholder="" name="price" id="editServicePrice" style="padding-left: 50px;" value="{{number_format((float)$data->price, 2, '.', '')}}">
      <span class="static-tag1 col-black"> NZ$  </span>
   </div>
   <div class="form-field2">
      @php $webpr = (($data->price/100)*$mtp->gst)+$data->price; @endphp
      <p> WEBSITE SALE PRICE (INC GST) <sup class="col-red">*</sup> </p>
      <input type="number" step="any" placeholder="" id="editServiceSalePrice" style="padding-left: 50px;" value="{{number_format((float)$webpr, 2, '.', '')}}" disabled>
      <span class="static-tag1 col-black"> NZ$  </span>
   </div>
   <div class="form-field2">
      @php $homepr = $data->price-(($data->price/100)*$mtp->comission); @endphp
      <p> YOUR TAKEHOME (AFTER GST & FEES) <sup class="col-red">*</sup> </p>
      <input type="number" step="any" placeholder="" id="editServiceTakehomePrice" style="padding-left: 50px;" value="{{number_format((float)$homepr, 2, '.', '')}}" disabled>
      <span class="static-tag1 col-black"> NZ$  </span>
   </div>
   <div class="form-field2">
      <p> DESCRIPTION </p>
      <textarea placeholder="Please enter description" rows="2" name="description">{{$data->description}}</textarea>
   </div>
   <div class="form-field2">
      <p>PREPRATION </p>
      <textarea placeholder="Please enter description" name="long_description">{{$data->long_description}}</textarea>
   </div>

   <div class="block-element submit-buttons mob-text-left text-right">
      <button type="reset" class="bg-silver  col-black normal-btn rounded" data-dismiss="modal" aria-label="Close"> Cancel  </button>
      <button type="submit" class="bg-blue col-white normal-btn rounded"> Update </button>
   </div>
</form>