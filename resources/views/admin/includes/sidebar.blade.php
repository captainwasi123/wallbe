<section class="sidebar-left">
    <div class="sidebar-custom">
       <div class="sidebar-logo">
          <a href=""> <img alt="logo" src="{{URL::to('/public/assets/web/new/')}}/images/wellbe-logo.png" style="height: 50px;"> </a>
          <button class="menu-hamburger"> <img alt="hamburger" src="images/hamburger.png"> </button>
       </div>
       <div class="sidebar-menu">
          <div class="menu-item">
             <a href="{{route("admin.dashboard")}}" class="active"> <i class="fa fa-home"> </i> Dashboard </a>
          </div>
          <div class="menu-item">
             <a class="menu-onn"> <i class="fa fa-folder"> </i>  My Bookings <i class="fa fa-caret-right  menu-icon"> </i> </a>
             <ol class="sub-menu" style="display: none;">
                <li> <a href="{{route("admin.upcomming")}}"> <b> . </b> Upcoming </a></li>
                <li> <a href="{{route("admin.inprogress")}}"> <b> . </b> In Progress </a></li>
                <li> <a href="{{route("admin.completed")}}"> <b> . </b> Completed </a></li>
                <li> <a href="{{route("admin.cancelled")}}"> <b> . </b> Cancelled </a></li>
                <li> <a href="{{route("admin.incomplete")}}"> <b> . </b> Incomplete </a></li>
             </ol>
          </div>
          <div class="menu-item">
             <a href="{{route("admin.customers")}}"> <i class="fa fa-users"> </i> Customers </a>
          </div>

          <div class="menu-item">
             <a href="{{route("admin.practitioners")}}"> <i class="fa fa-user"> </i> Practitioners </a>
          </div>
           <div class="menu-item">
             <a href="{{route("admin.categories")}}"> <i class="fas fa-align-center"></i>  Categories </a>
           </div>

          <div class="menu-item">
             <a class="menu-onn"> <i class="fa fa-user-plus"> </i>  My Profile <i class="fa fa-caret-right  menu-icon"> </i> </a>
             <ol class="sub-menu" style="display: none;">
                <li> <a href="{{route("admin.edit_profile")}}"> <b> . </b> Edit Profile </a></li>
             </ol>
          </div>



       </div>
       <div class="sidebar-btn-fixed">
          <a href="{{URL::to('/')}}" target="_blank"> <i class="fa fa-globe"> </i> Go to Wellbe </a>
       </div>
    </div>
 </section>
