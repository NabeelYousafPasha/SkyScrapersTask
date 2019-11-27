@extends('dashboard.layout.app')
@section('stylesheets')
    <link href="{{ asset('backend-assets/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
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
            @if((auth()->user()->type ?? '') == 'super_admin')
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add New</a>
            @endif
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>List of All {{ $page_title }}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    @if((auth()->user()->type ?? '') == 'super_admin')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($users))
                                    <?php $count = 0; ?>
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            @if((auth()->user()->type ?? '') == 'super_admin')
                                            <td>
                                                <div class="btn-group btn-group-xs">
                                                    <a title="Edit" href="{{ route('users.edit', $user) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                                    <form class="form-user-delete" method="POST" action="{{ route('users.delete', $user) }}" style="display: inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button title="Delete" type ="submit" class="btn btn-danger btn-xs">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ___________________________ MODAL DELETE __________________________ --}}
    <div class="modal inmodal" id="userDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Delete {{ $entity }}</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this {{ $entity }}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="user_delete_btn">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('backend-assets/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv', title: 'Users'},
                    {extend: 'excel', title: 'Users'},
                    {extend: 'pdf', title: 'Users'},

                    {extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });

        });
    </script>
    <script type="text/javascript">
        $('.form-user-delete').on('click', function(e){
            e.preventDefault();
            var $form = $(this);
            $('#userDeleteModal').modal({ backdrop: 'static', keyboard: false })
                .on('click', '#user_delete_btn', function(){
                    $form.submit();
                });
        });
    </script>
@endsection
