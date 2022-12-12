<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">

  <div class="brand-logo">
    <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
    <h5 class="logo-text">Dashboard Admin</h5>
    <div class="close-btn"><i class="zmdi zmdi-close"></i></div>
  </div>

  <ul class="metismenu" id="menu">
    <li>
      <a href="{{url('/admin/dashboard')}}">
        <div class="parent-icon"><i class="zmdi zmdi-view-dashboard"></i></div>
        <div class="menu-title">Dashboard</div>
      </a>

    </li>
    <li>
      <a href="{{url('/admin/money')}}">
        <div class="parent-icon"> <i class='zmdi zmdi-money'></i></div>
        <div class="menu-title">Quy định tiền</div>
      </a>
    </li>
    <li>
      <a class="has-arrow" href="javascript:void();">
        <div class="parent-icon"> <i class='zmdi zmdi-layers'></i></div>
        <div class="menu-title">Danh sách game</div>
      </a>
      <ul>
        <li><a href="{{url('/admin/games')}}"><i class="zmdi zmdi-dot-circle-alt"></i> Danh Sách</a></li>

      </ul>
    </li>

    <li>
      <a class="has-arrow" href="javascript:void();">
        <div class="parent-icon"> <i class='fa fa-user'></i></div>
        <div class="menu-title">Quản lý người dùng</div>
      </a>
      <ul>
        <li><a href="{{url('/admin/users')}}"><i class="zmdi zmdi-dot-circle-alt"></i> Danh sách</a></li>
        <li><a href="{{url('/admin/bet-users')}}"><i class="zmdi zmdi-dot-circle-alt"></i> Người dùng chọn số</a></li>
      </ul>
    </li>


    <li>
      <a href="{{url('/admin/policy')}}">
        <div class="parent-icon"> <i class='zmdi zmdi-widgets'></i></div>
        <div class="menu-title">Điều khoản chính sách</div>
      </a>
    </li>

    

    

    
    <li>
      <a href="{{url('/admin/app')}}">
        <div class="parent-icon"> <i class='zmdi zmdi-grid'></i></div>
        <div class="menu-title">Về ứng dụng</div>
      </a>
    </li>
    
  </ul>

</div>