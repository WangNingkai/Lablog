<?php

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavController extends Controller
{
    protected $nav;

    public function __construct(Nav $nav)
    {
        $this->nav = $nav;
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


    public function destroy($id)
    {
        //
    }
}
