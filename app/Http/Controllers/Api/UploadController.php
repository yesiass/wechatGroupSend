<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;

/**
 * 上传接口
 * Class UploadController
 * @package App\Api\Controllers
 */
class UploadController extends AdminBaseController
{
    public function uploadImg(Request $request)
    {
        $path = $request->file('image')->store('image','public');
        if ($path){
            $image_path = $path;
            $error = 0;
            $msg = '上传成功!';
        }else{
            $error = 1;
            $image_path = '';
            $msg = '上传失败!';
        }
        $data = [
            'error' => $error,
            'msg'   => $msg,
            'url'   => $image_path,
        ];
        return response()->json($data);
    }
}