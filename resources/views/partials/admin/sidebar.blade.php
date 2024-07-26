<!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{route('admin.dashboard')}}" class="logo">
              <!-- <img
                src="{{asset('assets/img/kaiadmin/logo_light.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              /> -->
              <span style="color:#fff">CRM</span>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="{{ route('admin.dashboard')}}"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('lead.list') }}">
                  <i class="fas fa-layer-group"></i>
                  <p>Lead</p>
                  <span class="caret"></span>
                </a>
                   
              </li>
              <li class="nav-item">
              <a href="{{ route('customer.list') }}">
                  <i class="fas fa-layer-group"></i>
                  <p>Customer</p>
                  <span class="caret"></span>
                </a>
                   
              </li>
              <li class="nav-item">
              <a href="{{ route('staff.list') }}">
                  <i class="fas fa-layer-group"></i>
                  <p>Staff</p>
                  <span class="caret"></span>
                </a>
                   
              </li>
              
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->