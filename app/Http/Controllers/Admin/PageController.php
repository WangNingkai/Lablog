<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{

    /**
     * @var Page
     */
    protected $page;

    /**
     * PageController constructor.
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function manage()
    {


    }


    public function create()
    {

    }


    public function store(Request $request)
    {

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {
        //
    }


    public function delete(Request $request, $id)
    {
        //
    }


    public function trash(Request $request, $id)
    {
        //
    }


    public function restore(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
