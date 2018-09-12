<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Push;

class PushController extends Controller
{
    /**
     * @var Push
     */
    protected $push;

    /**
     * PageController constructor.
     * @param Push $push
     */
    public function __construct(Push $push)
    {
        $this->push = $push;
    }

    public function list(Request $request)
    {
        $keyword = $request->get('keyword') ?? '';
        $map = [];
        $keyword ? array_push($map, ['subject', 'like', '%' . $keyword . '%']) : null;
        $pushes =  $this->push
            ->query()
            ->select('id', 'subject','method','status', 'started_at')
            ->where($map)
            ->orderBy('started_at', 'desc')
            ->paginate(10);
        $subscribes = Subscribe::all();
        return view('admin.push', compact('pushes','subscribes'));

    }

    public function info()
    {

    }


    public function store()
    {

    }
}
