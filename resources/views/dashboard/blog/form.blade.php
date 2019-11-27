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
                            <div class="col-md-12">
                                @if(isset($blog))
                                    <form method="POST" action="{{ route('blogs.update', $blog) }}" id="blog-form-edit" autocomplete="off">
                                        @method('PATCH')
                                @else
                                    <form method="POST" action="{{ route('blogs') }}">
                                @endif
                                        @csrf

                                        <div class="form-group @error('blog_title') is-invalid has-error @enderror">
                                            <label for="blog_title" class="col-form-label text-md-right">
                                                {{ __('Title') }} *
                                            </label>

                                            <div class="">
                                                <input
                                                    id="blog_title"
                                                    type="text"
                                                    class="form-control @error('blog_title') is-invalid has-error @enderror"
                                                    name="blog_title"
                                                    value="{{ $blog->blog_title ?? old('blog_title') }}"
                                                    required
                                                    autofocus
                                                >

                                                @error('blog_title')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group @error('blog_description') is-invalid has-error @enderror">
                                            <label for="blog_description" class="col-form-label text-md-right">
                                                {{ __('Description') }} *
                                            </label>

                                            <div class="">
                                                <textarea
                                                    id="blog_description"
                                                    class="form-control textarea"
                                                    name="blog_description"
                                                    placeholder="Description"
                                                    rows="7"
                                                    maxlength="3000"
                                                >{!! $blog->blog_description ?? old('blog_description') !!}</textarea>

                                                @error('blog_description')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group text-right">
                                            <button class="btn btn-default"><a href="{{ url()->previous() }}">Cancel</a></button>
                                            <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Save</button>
                                        </div>
                                    </form>
                            </div>
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
