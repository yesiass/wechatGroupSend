<?php

namespace App\Http\Controllers;

/**
 * 基类
 * Class AdminBaseController
 * @package App\Http\Controllers
 */
class AdminBaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
