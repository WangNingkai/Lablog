<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OperationLog;

class OperationLogsController extends Controller
{
    protected $operationLogs;

    public function __construct(OperationLog $operationLogs)
    {
        $this->operationLogs = $operationLogs;
    }

    public function manage()
    {

    }
}
