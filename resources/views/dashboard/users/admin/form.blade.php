@extends('dashboard.layout.app')
@section('stylesheets')
    {{-- Mask CSS --}}
    <link href="{{ asset('backend-assets/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    {{-- Select 2 CSS --}}
    <link href="{{ asset('backend-assets/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    {{-- iCheck CSS --}}
    <link href="{{ asset('backend-assets/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('backend-assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <!-- Ladda style -->
    <link href="{{ asset('backend-assets/css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $page_title }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ '/' }}">Home</a>
                </li>
                <li class="active">
                    <strong>{{ $page_title }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2" style="float: right;">
            <h2></h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ $entity_action }} {{ $entity }}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                @if(isset($admin))
                                    <form method="POST" action="{{ route('admins.update', $admin) }}" id="user-form-edit" autocomplete="off">
                                        @method('PATCH')
                                @else
                                    <form method="POST" action="{{ route('admins') }}">
                                @endif
                                        @csrf

                                        <div class="form-group row @error('name') is-invalid has-error @enderror">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                                {{ __('Name') }} *
                                            </label>

                                            <div class="col-md-8">
                                                <input
                                                    id="name"
                                                    type="text"
                                                    class="form-control @error('name') is-invalid has-error @enderror"
                                                    name="name"
                                                    value="{{ $admin->name ?? old('name') }}"
                                                    required
                                                    autofocus
                                                >

                                                @error('name')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row @error('email') is-invalid has-error @enderror">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                                {{ __('E-Mail Address') }} *
                                            </label>

                                            <div class="col-md-8">
                                                <input
                                                    id="email"
                                                    type="email"
                                                    class="form-control @error('email') is-invalid has-error @enderror"
                                                    name="email"
                                                    value="{{ $admin->email ?? old('email') }}"
                                                    required
                                                >

                                                @error('email')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(isset($admin))
                                        @else
                                        <div class="form-group row @error('password') is-invalid has-error @enderror">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">
                                                {{ __('Password') }} *
                                            </label>

                                            <div class="col-md-8">
                                                <input
                                                    id="password"
                                                    type="password"
                                                    class="form-control @error('password') is-invalid has-error @enderror"
                                                    name="password"
                                                    required
                                                >

                                                @error('password')
                                                    <span class="invalid-feedback text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                                {{ __('Confirm Password') }} *
                                            </label>

                                            <div class="col-md-8">
                                                <input
                                                    id="password-confirm"
                                                    type="password"
                                                    class="form-control"
                                                    name="password_confirmation"
                                                    required
                                                >
                                            </div>
                                        </div>
                                        @endif

                                        <div class="form-group text-right">
                                            <button class="btn btn-default"><a href="{{ url()->previous() }}">Cancel</a></button>
                                            <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Save</button>
                                        </div>
                                    </form>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Select2 JS -->
    <script src="{{ asset('backend-assets/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(".select2").select2();
        });
    </script>
    <!-- iCheck -->
    <script src="{{ asset('backend-assets/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <!-- Ladda -->
    <script src="{{ asset('backend-assets/js/plugins/ladda/spin.min.js') }}"></script>
    <script src="{{ asset('backend-assets/js/plugins/ladda/ladda.min.js') }}"></script>
    <script src="{{ asset('backend-assets/js/plugins/ladda/ladda.jquery.min.js') }}"></script>
    <script>
        $(document).ready(function (){
            // Bind normal buttons
            Ladda.bind( '.ladda-button',{ timeout: 2000 });
        });
    </script>

@endsection
