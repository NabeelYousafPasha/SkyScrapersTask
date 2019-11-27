<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Requests\BloggerRequest;
use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;
use Session;

class BlogController extends Controller
{
    private $page_title = "Blogs";
    private $entity = "Blog";
    private $entity_action = "Publish New";

    function __construct()
    {
        parent::__construct();
        $this->middleware('auth:blogger');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if((auth()->user()->hasPermissionTo('blog_view') != true))
            return $this->permission_denied('blogger_dashboard');

        $blogs = Blog::where('fk_blogger_id', $this->loggedInUser->id)
                ->get();
//        dd(auth()->user()->blogger_blogs);
//        $blogs = Blog::get();
        return view('dashboard.blog.list')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => $this->entity_action,
            ])
            ->with('blogs', $blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if((auth()->user()->hasPermissionTo('blog_add') != true))
            return $this->permission_denied('blogger_dashboard');

        return view('dashboard.blog.form')
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
    public function store(BlogRequest $request)
    {
        if((auth()->user()->hasPermissionTo('blog_add') != true))
            return $this->permission_denied('blogger_dashboard');

        $blog = new Blog();
        $blog->fill($request->all());
        $blog->fk_blogger_id = auth()->user()->id;
        $blog->save();

        $status = $blog->save() ? array(
            'msg' => "New Blog has been published successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('blogs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        if((auth()->user()->hasPermissionTo('blog_edit') != true))
            return $this->permission_denied('blogger_dashboard');

        return view('dashboard.blog.form')
            ->with([
                'page_title' => $this->page_title,
                'entity' => $this->entity,
                'entity_action' => 'Edit',
            ])
            ->with('blog', $blog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        if((auth()->user()->hasPermissionTo('blog_edit') != true))
            return $this->permission_denied('blogger_dashboard');

        $blog->fill($request->all())->save();

        $status = $blog->save() ? array(
            'msg' => "Blog has been updated successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('blogs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if((auth()->user()->hasPermissionTo('blog_delete') != true))
            return $this->permission_denied('blogger_dashboard');

        $status = $blog->delete() ? array(
            'msg' => "Blog has been deleted successfully!",
            'toastr' => "successToastr") : array(
            'msg' => "Some Error occured. Try again.",
            'toastr' => "errorToastr");

        Session::flash($status['toastr'], $status['msg']);
        return redirect()->route('blogs');
    }
}
