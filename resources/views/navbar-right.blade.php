<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <li>
            <a href="#">
                <span>Logged as <b>{{ Auth::user()->fullname }}</b></span>
            </a>
        </li>
        <li>
            <a href="{{ app('url')->to('auth/logout') }}"><i class="fa fa-sign-out"></i></a>
        </li>
    </ul>
</div>