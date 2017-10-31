<?php
namespace App\Http\Controllers\CustomerService;

use App\Http\Controllers\AdminBaseController;
use App\Models\CustomerService;
use App\Models\Files;
use App\Models\FollowTick;
use Illuminate\Http\Request;

/**
 * 关注定时服务
 * Class CustomerServiceController
 * @package App\Http\Controllers\CustomerService
 */
class CustomerServiceController extends AdminBaseController
{
    /**
     * 关注定时发送消息设置
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|int
     */
    public function index(Request $request,$id)
    {
        $customerServiceModel = new CustomerService();
        $kf_list = $customerServiceModel ->getList($id);
        $data['data'] = $kf_list;
        if ($request->isMethod('post')) {
            $followReplyModel = new FollowTick();
            $post = $request->post();
            $post['account_id'] = $id;
            $post['msgtype'] = $post['msg_type'];
            unset($post['_token']);
            unset($post['msg_type']);
            $hasReply = $followReplyModel->find($id);
            if ($hasReply) {
                $result = $followReplyModel->where('account_id', $id)->update($post);
            } else {
                $result = $followReplyModel->insert($post);
            }
            return (int)$result;
        } else {
            $followReplyModel = new FollowTick();
            $data = $followReplyModel->find($id);
            if (is_object($data)) {
                $data->msg_type = $data->msgtype;
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
            return view('customerservice/index',$view_data);
        }

    }
}