<?php
namespace App\Http\Controllers\InterfaceLog;

use App\Http\Controllers\AdminBaseController;
use App\Models\InterfaceLog;

/**
 * 接口日志类
 * Class InterfaceLogController
 * @package App\Http\Controllers\GroupSending
 */
class InterfaceLogController extends AdminBaseController
{
    public function index()
    {
        $interfaceLogModel = new InterfaceLog();
        $data = $interfaceLogModel ->get_logs();
        return view('/interfacelog/index',compact('data',$data));
    }
}