
@inject('request', 'Illuminate\Http\Request')

<!--  SIDEBAR -->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    {{-- <span><center>
                        <img alt="image" class="img-circle img-responsive" src="{{ asset('backend-assets/ellipsis-techs-logo.png') }}" />
                    </center></span> --}}
                    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0)">
                        <span class="clear">
                            <span class="block m-t-xs text-center">
                                <strong class="font-bold">
                                    {{ config('app.name', 'Laravel') }}
                                </strong>
                            </span>
                            {{-- <span class="text-muted text-xs block text-center">Software Solutions</span> --}}
                        </span>
                    </a>
                </div>
                <div class="logo-element">
                    SS
                </div>
            </li>

            <li
                class="{{
                    ($request->segment(1) == 'home'
                    || Request::is('/')
                    || Request::is('admin_dashboard')
                    || Request::is('user_dashboard')
                    || Request::is('blogger_dashboard')) ? 'active' : '' }}">

                @php
                    $href = '/';
                @endphp
                @auth('admin')
                    @php
                        $href = 'admin_dashboard';
                    @endphp
                @endauth

                @auth('user')
                    @php
                        $href = 'user_dashboard';
                    @endphp
                @endauth

                @auth('blogger')
                    @php
                        $href = 'blogger_dashboard';
                    @endphp
                @endauth

                <a href="{{ route($href) }}">
                    <i class="fa fa-th-large fa-fw"></i> <span class="nav-label">Dashboard</span>
                </a>
            </li>

            @can('role_permission_view', 'admin')
                @if((auth()->user()->type ?? '') == 'super_admin')
            <li
                class="{{
                    ($request->segment(1) == 'permission_role') ? 'active' : '' }}">
                <a href="{{ route('permission_role') }}">
                    <i class="fa fa-check-square-o fa-fw"></i> <span class="nav-label">Permissions Roles</span>
                </a>
            </li>
                @endif
            @endcan

            @can('admin_view', 'admin')
                @if((auth()->user()->type ?? '') == 'super_admin')
            <li
                class="{{
                    ($request->segment(1) == 'admins') ? 'active' : '' }}">
                <a href="{{ route('admins') }}">
                    <i class="fa fa-user-secret fa-fw"></i> <span class="nav-label">Admins</span>
                </a>
            </li>
                @endif
            @endcan

            @can('user_view', 'admin')
            <li
                class="{{
                    ($request->segment(1) == 'users') ? 'active' : '' }}">
                <a href="{{ route('users') }}">
                    <i class="fa fa-users fa-fw"></i> <span class="nav-label">Users</span>
                </a>
            </li>
            @endcan

            @can('blogger_view', 'blogger')
            <li
                class="{{
                    ($request->segment(1) == 'bloggers') ? 'active' : '' }}">
                <a href="{{ route('bloggers') }}">
                    <i class="fa fa-user-circle-o fa-fw"></i> <span class="nav-label">Bloggers</span>
                </a>
            </li>
            @endcan

            @can('blog_view', 'blogger')
            <li
                class="{{
                    ($request->segment(1) == 'blogs') ? 'active' : '' }}">
                <a href="{{ route('blogs') }}">
                    <i class="fa fa-file-text-o fa-fw"></i> <span class="nav-label">Blogs</span>
                </a>
            </li>
            @endcan

        </ul>
    </div>
</nav>
