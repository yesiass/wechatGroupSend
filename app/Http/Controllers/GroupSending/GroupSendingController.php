<?php
namespace App\Http\Controllers\GroupSending;

use App\Http\Controllers\AdminBaseController;
use App\Models\Files;
use App\Models\GroupSend;
use Illuminate\Http\Request;

/**
 * 群发
 * Class GroupSendingController
 * @package App\Http\Controllers\GroupSending
 */
class GroupSendingController extends AdminBaseController
{
    /**
     * 获取群发列表
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_list($id)
    {
        $groupSendModel = new GroupSend();
        $data = $groupSendModel ->where('account_id',$id) ->orderBy('id','desc') ->paginate(25);
        return view('groupsending/list', compact('data',$data,'id',$id));
    }

    /**
     * 群发
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|int
     */
    public function index(Request $request,$id)
    {
        if ($request->isMethod('post')) {
            $groupSendModel = new GroupSend();
            $post = $request->post();
            $post['account_id'] = $id;
            unset($post['_token']);
            $result = $groupSendModel->insert($post);
            return (int)$result;
        }else {
            return view('groupsending/index',compact('id',$id));
        }
    }

    /**
     * 显示群发详细
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        $groupSendModel = new GroupSend();
        $data = $groupSendModel->orderBy('id','desc')->find($id);
        if (is_object($data)) {
            $view_data = ['data' => $data];
            if (isset(json_decode($data->contents, true)['contents'])) {
                $view_data['contents'] = json_decode($data->contents, true)['contents'];
            } elseif (isset(json_decode($data->contents, true)['articles'])) {
                $view_data['articles'] = json_decode($data->contents, true)['articles'];
            }elseif (isset(json_decode($data->contents, true)['media_id'])){
                $filesModel = new Files();
                $view_data['media_id']['url'] = $filesModel ->where('media_id',
                    json_decode($data->contents, true)['media_id']) ->value('url');
                $view_data['media_id']['media_id'] = json_decode($data->contents, true)['media_id'];
            }
            $view_data['id'] = $id;
        } else {
            unset($data);
            $view_data['id'] = $id;
        }
        return view('groupsending/details', $view_data);
    }

    /**
     * 群发开始
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send($id)
    {
        //请求api群发消息
        $data = file_get_contents('http://asd.mogudao.cn/reply/defaults/sendall?id='.$id);
        $result_data = json_decode($data,true);
        $groupSendModel = new GroupSend();
        $modelWhere = $groupSendModel ->where('id',$id);
        $account_id = $modelWhere ->value('account_id');
        if(isset($result_data['code'])){
            if ($result_data['code'] == 1){
                    return redirect('/groupsending/list/'.$account_id)->with('message', '已开始发送中!');
            }else{
                return redirect('/groupsending/list/'.$account_id)->with('message', '发送失败！');
            }
        }else{
            return redirect('/groupsending/list/'.$account_id)->with('message', '发送失败！');
        }
    }

    /**
     * 获取群发运行日志
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function task_log($id)
    {
        $groupSendModel = new GroupSend();
        $data = $groupSendModel ->get_task_log($id);
        return view('groupsending/task_log',compact('data',$data));
    }
}