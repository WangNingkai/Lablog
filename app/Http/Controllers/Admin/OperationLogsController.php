<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OperationLog;

class OperationLogsController extends Controller
{
    /**
     * @var OperationLog
     */
    protected $operation_logs;

    /**
     * OperationLogsController constructor.
     * @param OperationLog $operation_logs
     */
    public function __construct(OperationLog $operation_logs)
    {
        $this->operation_logs = $operation_logs;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        // 日志
        $operation_logs = $this->operation_logs
            ->select('id', 'operator', 'operation','operation_time','ip','address','device','browser','platform','language','device_type')
            ->orderBy('operation_time','desc')
            ->paginate(10);
        return view('admin.operation-logs', compact('operation_logs'));
    }

    /**
     * 日志删除.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $data = $request->only('opid');
        $arr = explode(',', $data['opid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->operation_logs->destroyData($map);
        operation_event(auth()->user()->name,'删除日志');
        return redirect()->back();
    }
}
