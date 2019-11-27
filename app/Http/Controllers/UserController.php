<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{
    private $page_title = "Users";
    private $entity = "User";
    private $entity_action = "Add New";

    function __construct()
    {
        $this->middleware('auth:user')->only('dashboard');
        $this->middleware('auth:admin')->only(['index', 'create', 'store', 'edit', 'update', 'delete']);
    }

    protected function guard()
    {
        return \Auth::guard('user');
    }


    public function dashboard()
    {
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
        $users = User::get();
        return view('dashboard.users.user.list')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => $this->entity_action,
            ])
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if((auth()->user()->hasPermissionTo('user_add', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('users');

        return view('dashboard.users.user.form')
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
    public function store(UserRequest $request)
    {
        if((auth()->user()->hasPermissionTo('user_add', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('users');

        $user = new User();
        $user->fill($request->all())->save();

        $status = $user->save() ? array(
            'msg' => "User has been registered successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if((auth()->user()->hasPermissionTo('user_edit', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('users');

        return view('dashboard.users.user.form')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => 'Edit',
            ])
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if((auth()->user()->hasPermissionTo('user_edit', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('users');

        $user->fill($request->all())->save();

        $status = $user->save() ? array(
            'msg' => "User has been updated successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if((auth()->user()->hasPermissionTo('user_delete', 'admin') != true) || (auth()->user()->type ?? '') != 'super_admin')
            return $this->permission_denied('users');

        $status = $user->delete() ? array(
            'msg' => "User has been deleted successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('users');
    }
}
