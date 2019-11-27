<!DOCTYPE html>
<html>
<!-- --------------------------    header stylesheets   -------------------------------- -->
<head>
	@include('dashboard.partials.header')
	@yield('stylesheets')
</head>

<body>
    <div id="wrapper">
<!-- ----------------------------------    sidebar    ----------------------------------- -->
    	@include('dashboard.partials.sidebar')

    	<div id="page-wrapper" class="gray-bg dashbard-1">
<!-- ----------------------------------     navbar    ----------------------------------- -->
    	   @include('dashboard.partials.navbar')

           @if (Session::has('message'))
                <div class="alert alert-info alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <div class="note note-info">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                </div>
            @endif
            @if ($errors->count() > 0)
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <div class="note note-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
                    
    	   @yield('content')

           @include('dashboard.partials.credits')
    	</div>
    </div>
<!-- ---------------------------       footer scripts      ---------------------------- -->
	@include('dashboard.partials.footer')
    {{-- @include('sweetalert::alert') --}}
    @yield('scripts')
</body>
</html>
















<!--
***********************************************************
OEPS- Online Enrollment Problem Solver
Nabeel Yousaf Pasha
14-ARID-3675
0321-5031089
nabeelyousafpasha@gmail.com
***********************************************************
-->