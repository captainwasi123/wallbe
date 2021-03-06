<header>
   <div class="container">
      <div class="logo">
         <a href="{{route('home')}}"> <img alt="logo" src="{{URL::to('/')}}/public/assets/web/images/logo.png"> </a>
      </div>
      <div class="header-right">
        <?php if (Auth::guard('admin')->check()) { ?>
          <div class="dropdown loggedIn">
            <a class="dropdown-toggle" type="button" data-toggle="dropdown">
              <img alt="user-pic" src="" onerror="this.onerror=null;this.src='{{URL::to('/')}}/public/assets/images/user-placeholder.png';">
              {{empty(Auth::guard('admin')->user()->first_name) ? 'New User' : ' '.Auth::guard('admin')->user()->first_name}}&nbsp;&nbsp;&nbsp;&#9660;
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{route('admin.dashboard')}}">Return to admin account</a></li>
              <li><a href="{{route('admin.edit_profile')}}"> My Account </a></li>
             <li><a href="{{route('admin.logout')}}"> </i> Logout </a></li>
            </ul>
          </div>
        <?php }elseif (Auth::check()) { ?>
          <div class="dropdown loggedIn">
            <a class="dropdown-toggle" type="button" data-toggle="dropdown">
              <img alt="user-pic" src="{{URL::to('/')}}/{{Auth::user()->profile_img}}" onerror="this.onerror=null;this.src='{{URL::to('/')}}/public/assets/images/user-placeholder.png';">
              {{Auth::user()->first_name}}&nbsp;&nbsp;&nbsp;&#9660;
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{Auth::user()->user_type == '1' ? route('practitioner.dashboard') : route('booker.index')}}">Dashboard</a></li>
              <li><a href="{{Auth::user()->user_type == '1' ? route('practitioner.profile') : route('booker.profile')}}">Profile</a></li>
              <li><a href="{{URL::to('/logout')}}">Logout</a></li>
            </ul>
          </div>
        <?php }else{ ?>
            <a  class="login-btn" data-toggle="modal" data-target=".login-modal"> Log in </a>
            <a href="" class="pro-btn" data-toggle="modal" data-target=".pro-modal"> Become a Pro </a>
        <?php } ?>
      </div>
      <div class="navbar-handler">
         <img src="{{URL::to('/')}}/public/assets/web/images/hamburger.png">
      </div>
      <div class="navbar-custom">
         <div class="menu-item">
            <a href="{{route('treatments')}}"> Treatments </a>
         </div>
         <div class="menu-item">
            <a href="{{route('professionals')}}"> Professionals </a>
         </div>
         <div class="menu-item">
            <a href=""> About </a>
         </div>
         <div class="menu-item">
            <a href=""> Contact Us </a>
         </div>
      </div>
   </div>
</header>

<div class="modal fade modal-size2 login-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document" style="max-width: 550px;">
    <div class="modal-content">
      <button type="button" class="close1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span> </button>
      <div class="custom-modal-triggers">
        <ul class="nav nav-tabs" role="tablist">
        	<li class="nav-item">
         		<a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Login</a>
         	</li>
         	<li class="nav-item">
         		<a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Sign Up</a>
         	</li>
        </ul>
      </div>
      <div class="custom-modal-head">
      </div>
      <div class="custom-modal-data">
       	<div class="tab-content">
         	<div class="tab-pane active" id="tabs-1" role="tabpanel">
            <br>
            <form id="loginForm" action="{{URL::to('/loginAttempt')}}">
              <input type="hidden" name="_token" id="loginToken" value="{{csrf_token()}}">
              <div class="form-field6">
                <p> Email Address </p>
                <input type="email" name="email" id="email" required>
              </div>
              <div class="form-field6">
                <p> Password </p>
                <input type="password" name="password" id="password" required>
              </div>
              <div class="forgot-password">
                <a href=""> Forgot Password? </a>
              </div>
             	<div class="form-field7 text-center">
                <button id="login" class="bg-blue col-white normal-btn rounded"> Login </button>
              </div>
            </form>
         	</div>
         	<div class="tab-pane" id="tabs-2" role="tabpanel">
            <br>
            <form method="post" action="{{URL::to('/register')}}">
              @csrf

              <input type="hidden" name="userType" value="2">

              <input type="hidden" class="form-control" name="status" value="0" required>

              <div class="row">
                <div class="col-md-6">
                  <label> First Name </label>
                  <input type="text" class="form-control" name="first_name" required>
                </div>
                <div class="col-md-6">
                  <label> Last Name </label>
                  <input type="text" class="form-control" name="last_name" required>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <label> Email Address </label>
                  <input type="email" class="form-control" name="email" required>
                </div>

                <div class="col-md-6">
                  <label> Phone </label>
                  <input type="number" class="form-control" name="phone">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <p> Password </p>
                  <input type="password" class="form-control" name="password" required>
                </div>
                <div class="col-md-6">
                  <p> Confirm Password </p>
                  <input type="password" class="form-control" name="confirmation_password" required>
                </div>
                <div class="col-md-12" id="register_error"></div>
                <div class="col-md-12">
                  <br>
                  <div class="form-field7 text-center">
                     <button class="bg-blue col-white normal-btn rounded"> SIGN UP </button>
                  </div>
                  <br>
                  <p class="modal-msg">Want to work with us? <a href="javascript:void(0)" data-dismiss="modal" data-toggle="modal" data-target=".pro-modal">Register here instead</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-size2 pro-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog" role="document" style="max-width: 550px;">
    <div class="modal-content">
      <button type="button" class="close1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">??</span> </button>
      <div class="custom-modal-triggers">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item" style="width:100%;">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Become a Pro</a>
          </li>
        </ul>
      </div>
      <div class="custom-modal-head">
      </div>
      <div class="custom-modal-data">
        <div class="tab-content">
          <div class="tab-pane active" id="tabs-2" role="tabpanel">
            <br>
            <form method="post" action="{{URL::to('/register')}}">
              @csrf
              <input type="hidden" name="userType" value="1">
              <div class="row">
                <div class="col-md-6">
                  <label> First Name </label>
                  <input type="text" class="form-control" name="first_name" required>
                </div>
                <div class="col-md-6">
                  <label> Last Name </label>
                  <input type="text" class="form-control" name="last_name" required>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <label> Email Address </label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                
                <div class="col-md-6">
                  <label> Phone </label>
                  <input type="number" class="form-control" name="phone">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <p> Password </p>
                  <input type="password" class="form-control" name="password" required>
                </div>
                <div class="col-md-6">
                  <p> Confirm Password </p>
                  <input type="password" class="form-control" name="confirmation_password" required>
                </div>
                <div class="col-md-12" id="register_error"></div>
                <div class="col-md-12">
                  <br>
                  <div class="form-field7 text-center">
                     <button class="bg-blue col-white normal-btn rounded"> SIGN UP </button>
                  </div>
                  <br>
                  <p class="modal-msg">Want to book our services? <a href="javascript:void(0)" data-dismiss="modal" data-toggle="modal" data-target=".login-modal">Register here instead</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
