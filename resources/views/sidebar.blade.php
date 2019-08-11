<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">Menu</li>
    <!--<li class="treeview">
        <a href="#"><i class="fa fa-file"></i> <span>Files</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#">Upload</a></li>
          <li><a href="#">List</a></li>
        </ul>
    </li>-->
    <li class="{{ app('request')->is('files*') ? 'active' : '' }}">
      <a href="{{ app('url')->to('files') }}">
        <i class="fa fa-folder"></i> <span>Files</span>
      </a>
    </li>
    @if( Auth::user()->isAdmin() )
    <li class="{{ app('request')->is('users*') ? 'active' : '' }}">
      <a href="{{ app('url')->to('users') }}">
        <i class="fa fa-users"></i> <span>Users</span>
      </a>
    </li>
    @endif
    <li>
      <a href="{{ app('url')->to('auth/logout') }}">
        <i class="fa fa-sign-out"></i> <span>Sign out</span>
      </a>
    </li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>