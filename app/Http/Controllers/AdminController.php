<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Session;

class AdminController extends Controller
{
    private $page_title = "Admins";
    private $entity = "Admin";
    private $entity_action = "Add New";

    function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function guard()
    {
        return \Auth::guard('admin');
    }


    public function dashboard()
    {
//        dd(auth()->user()->hasRole('admin', 'admin'));
        return view('dashboard.index')
            ->with('page_title', $this->page_title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if((auth()->user()->hasPermissionTo('admin_view', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');

        $admins = Admin::where('id', '<>', auth()->user()->id)
                    ->get();
        return view('dashboard.users.admin.list')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => $this->entity_action,
            ])
            ->with('admins', $admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if((auth()->user()->hasPermissionTo('admin_add', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');

        return view('dashboard.users.admin.form')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => $this->entity_action,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        if((auth()->user()->hasPermissionTo('admin_add', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');

        $admin = new Admin();
        $admin->fill($request->all())->save();

        $status = $admin->save() ? array(
            'msg' => "Admin has been registered successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('admins');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        if((auth()->user()->hasPermissionTo('admin_edit', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');

        return view('dashboard.users.admin.form')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => 'Edit',
            ])
            ->with('admin', $admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        if((auth()->user()->hasPermissionTo('admin_edit', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');

        $admin->fill($request->all())->save();

        $status = $admin->save() ? array(
            'msg' => "Admin has been updated successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('admins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        if((auth()->user()->hasPermissionTo('admin_delete', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');

        $status = $admin->delete() ? array(
            'msg' => "Admin has been deleted successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('admins');
    }



    public function getPermissionRole()
    {
        if((auth()->user()->hasPermissionTo('role_permission_view', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');

        $roles = \DB::table('roles')->get();
        $permissions = \DB::table('permissions')->get();
        $permission_role = \DB::table('role_has_permissions')
            ->select(\DB::raw('CONCAT(permission_id,"-",role_id) AS detail'))
            ->pluck('detail')->all();

        return view('dashboard.permission_role.list')
            ->with([
                'page_title' => __('Permission Role')
            ])
            ->with([
                'roles' => $roles,
                'permissions' => $permissions,
                'permission_role' => $permission_role,
            ]);
    }

    public function savePermissionRole(Request $request)
    {
        if((auth()->user()->hasPermissionTo('role_permission_add', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('admin_dashboard');
//        dd('Only for testing purpose');
        $insert = [];
        $permissions_roles = $request->input('permission_role') ?? [];
        foreach($permissions_roles as $perm => $roles)
            foreach($roles as $role => $value)
                $insert[] = array('permission_id' => $perm, 'role_id' => $role);

        \DB::table('role_has_permissions')->truncate();

        $perm_role = \DB::table('role_has_permissions')->insert($insert);

        $status = $perm_role ? array(
            'msg' => "Permissions have been assigned to respective Roles successfully!",
            'toastr' => "successToastr") : array(
                'msg' => "Some Error occured in procedding. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('permission_role');
    }
}
