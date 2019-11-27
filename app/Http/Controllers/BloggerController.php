<?php

namespace App\Http\Controllers;

use App\Blogger;
use App\Http\Requests\BloggerRequest;
use Illuminate\Http\Request;
use Session;

class BloggerController extends Controller
{
    private $page_title = "Bloggers";
    private $entity = "Blogger";
    private $entity_action = "Add New";

    function __construct()
    {
        $this->middleware('auth:blogger')->only('dashboard');
        $this->middleware('auth:admin,user')->only(['index', 'create', 'store', 'edit', 'update', 'delete']);
    }

    protected function guard()
    {
        return \Auth::guard('blogger');
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
//        it get redirects because of middleware (no need for this check)
        if((auth()->user()->hasPermissionTo('blogger_view') != true))
            return $this->permission_denied('blogger_dashboard');

//        dd(auth()->user());
        $bloggers = Blogger::get();
        return view('dashboard.users.blogger.list')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => $this->entity_action,
            ])
            ->with('bloggers', $bloggers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if((auth()->user()->hasPermissionTo('blogger_add') != true))
            return $this->permission_denied('blogger_dashboard');

        return view('dashboard.users.blogger.form')
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
    public function store(BloggerRequest $request)
    {
        if((auth()->user()->hasPermissionTo('blogger_add') != true))
            return $this->permission_denied('blogger_dashboard');

        $blogger = new Blogger();
        $blogger->fill($request->all())->save();

        $status = $blogger->save() ? array(
            'msg' => "Blogger has been registered successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('bloggers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blogger  $blogger
     * @return \Illuminate\Http\Response
     */
    public function show(Blogger $blogger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blogger  $blogger
     * @return \Illuminate\Http\Response
     */
    public function edit(Blogger $blogger)
    {
        if((auth()->user()->hasPermissionTo('blogger_edit') != true))
            return $this->permission_denied('blogger_dashboard');

        return view('dashboard.users.blogger.form')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => 'Edit',
            ])
            ->with('blogger', $blogger);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blogger  $blogger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blogger $blogger)
    {
        if((auth()->user()->hasPermissionTo('blogger_edit') != true))
            return $this->permission_denied('blogger_dashboard');

        $blogger->fill($request->all())->save();

        $status = $blogger->save() ? array(
            'msg' => "Blogger has been updated successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('bloggers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blogger  $blogger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blogger $blogger)
    {
        if((auth()->user()->hasPermissionTo('blogger_delete') != true))
            return $this->permission_denied('blogger_dashboard');

        $status = $blogger->delete() ? array(
            'msg' => "Blogger has been deleted successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('bloggers');
    }
}
