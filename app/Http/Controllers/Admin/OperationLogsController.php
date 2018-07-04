<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OperationLog;

class OperationLogsController extends Controller
{
    protected $operation_logs;

    public function __construct(OperationLog $operation_logs)
    {
        $this->operation_logs = $operation_logs;
    }

    public function manage()
    {
        // 日志
        $operation_logs = $this->operation_logs
            ->select('id', 'operater', 'operation','operation_time','ip','address','device','browser','platform','language','device_type')
            ->orderBy('operation_time','desc')
            ->get();
        return view('admin.operation_logs.manage', compact('operation_logs'));
    }

    /**
     * 日志删除.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only('opid');
        $arr = explode(',', $data['opid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->operation_logs->destroyData($map);
        return redirect()->back();
    }
}
