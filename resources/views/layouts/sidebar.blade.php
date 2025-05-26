<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

  <!-- LOGO -->
  <div class="navbar-brand-box">
    <a href="/" class="logo logo-dark">
      <span class="logo-sm">
        <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
      </span>
      <span class="logo-lg">
        <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="20">
      </span>
    </a>

    <a href="/" class="logo logo-light">
      <span class="logo-sm">
        <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
      </span>
      <span class="logo-lg">
        <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="20">
      </span>
    </a>
  </div>

  <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
    <i class="fa fa-fw fa-bars"></i>
  </button>

  <div data-simplebar class="sidebar-menu-scroll">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Menu</li>
         <li>
          <a href="/">
            <i class="uil-home-alt"></i>
            <span>Dashboard</span>
          </a>

        </li>
        @if (auth()->user()->hasAccess(['academic_year' => 'read']))
        <li><a href="/absence" class="waves-effect"><i class="uil-location-point"></i><span>absen</span></a></li>

        <li class="menu-title">Menu Data</li>
          <li><a href="/academic-year" class="waves-effect"><i class="uil-calender"></i><span>Tahun Ajaran</span></a>
          </li>
          <li><a href="/employee" class="waves-effect"><i class="uil-user-circle"></i><span>Semua Pengguna</span></a></li>
          <li><a href="/student" class="waves-effect"><i class="uil-user-nurse"></i><span>Semua Murid</span></a></li>
          <li><a href="/class" class="waves-effect"><i class="uil-database"></i><span>Rombongan Belajar</span></a></li>
        @endif
        @if (auth()->user()->hasAccess(['student_attendance' => 'read']))
        <li class="menu-title">Menu Guru</li>

          <li><a href="/student-attendance" class="waves-effect"><i class="uil-clock-three"></i><span>Kehadiran
                Murid</span></a></li>
                <li><a href="/report-attendance" class="waves-effect"><i class="uil-history"></i><span>Rekap Kehadiran
              Murid</span></a></li>
        @endif

        @if (auth()->user()->hasAccess(['academic_year' => 'read']))

        <li class="menu-title">Menu Akses</li>
        <li><a href="/role" class="waves-effect"><i class="uil-pen"></i><span>Role</span></a></li>
        <li><a href="/user" class="waves-effect"><i class="uil-user"></i><span>Akun User</span></a></li>
        @endif
        @if (auth()->user()->hasAccess(['student_attendance_ById' => 'read']))
        @endif
      </ul>
    </div>
    <!-- Sidebar -->
  </div>
</div>
<!-- Left Sidebar End -->
