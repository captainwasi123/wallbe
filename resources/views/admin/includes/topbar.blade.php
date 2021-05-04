<div class="dashboard-menu">
    <div class="user-dropdown">
       <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <img alt="user-pic" src="" onerror="this.onerror=null;this.src='{{URL::to('/')}}/public/assets/images/user-placeholder.png';">
          {{empty(Auth::guard('admin')->user()->first_name) ? 'New User' : ' '.Auth::guard('admin')->user()->first_name}}
          <span> Admin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <i class="fa fa-caret-down"> </i>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
             <div class="profile-info">
                <img alt="user-pic" src="" onerror="this.onerror=null;this.src='{{URL::to('/')}}/public/assets/images/user-placeholder.png';">
                <h5> Hello{{empty(Auth::guard('admin')->user()->first_name) ? '' : ' '.Auth::guard('admin')->user()->first_name}}, </h5>
                <h6> {{Auth::guard('admin')->user()->email}} </h6>
             </div>
             <li><a href="{{route('admin.edit_profile')}}"> <i class="fa fa-user"> </i> My Account </a></li>
             <li><a href="{{route('admin.logout')}}"> <i class="fa fa-sign-out-alt"> </i> Logout </a></li>
          </ul>
       </div>
    </div>
 </div>
