<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Nav\Store;
use App\Http\Requests\Nav\Update;
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
        $navs = $this->nav->getTreeIndex();
        $emptyNavs = $this->nav->query()
            ->select('id', 'name')
            ->where('type',$this->nav::TYPE_EMPTY)
            ->get();
        return view('admin.nav',compact('navs','emptyNavs'));
    }


    public function store(Store $request)
    {
        $this->nav->storeData($request->all());
        operation_event(auth()->user()->name,'添加菜单');
        return redirect()->back();
    }


    public function edit(Request $request)
    {

    }


    public function update(Update $request, $id)
    {
        //
    }


    public function destroy(Request $request)
    {
        //
    }
}
