<?php
namespace App\Http\Controllers\Account;

use App\Http\Controllers\AdminBaseController;
use App\Models\Account;
use App\Models\Files;
use App\Models\FollowReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * 账号管理
 * Class AccountController
 * @package App\Http\Controllers\Account
 */
class AccountController extends AdminBaseController
{

    /**
     * 账号列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $accountModel = new Account();
        $data = $accountModel->getList();
        return view('account/index', compact('data', $data));
    }

    /**
     * 添加账号
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $accountModel = new Account();
            $post = $request->post();
            unset($post['_token']);
            $post['passwd'] = Hash::make($post['passwd']);
            $result = $accountModel->insert($post);
            if ($result) {
                return redirect('/account')->with('message', '添加成功!');
            } else {
                return redirect('account/add')->with('message', '添加失败！');
            }
        } else {
            return view('account/add');
        }
    }

    /**
     * 修改账号
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function save(Request $request, $id)
    {
        $accountModel = new Account();
        if ($request->isMethod('post')) {
            $post = $request->post();
            unset($post['_token']);
            if(isset($post['passwd'])){
                $post['passwd'] = Hash::make($post['passwd']);
            }
            $result = $accountModel->where(['id' => $id])->update($post);
            if ($result) {
                return redirect('/account')->with('message', '修改成功!');
            } else {
                return redirect('account/save')->with('message', '修改失败！');
            }
        } else {
            $data = $accountModel ->getDetails($id);
            return view('account/save', compact('data', $data));
        }
    }

    /**
     * 删除账号
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function del($id)
    {
        $accountModel = new Account();
        $result = $accountModel->where(['id' => $id])->delete();
        if ($result) {
            return redirect('/account')->with('message', '删除成功!');
        } else {
            return redirect('/account')->with('message', '删除失败！');
        }
    }

    /**
     * 账号关注回复
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|int
     */
    public function reply(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $followReplyModel = new FollowReply();
            $post = $request->post();
            $post['account_id'] = $id;
            unset($post['_token']);
            $hasReply = $followReplyModel->find($id);
            if ($hasReply) {
                $result = $followReplyModel->where('account_id', $id)->update($post);
            } else {
                $result = $followReplyModel->insert($post);
            }
            return (int)$result;
        } else {
            $followReplyModel = new FollowReply();
            $data = $followReplyModel->find($id);
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
            return view('account/reply', $view_data);
        }
    }

    /**
     * 微信图片素材上传
     * @param Request $request
     * @return mixed
     */
    public function upload_image(Request $request)
    {
        $access_token = $request->post('access_token');
        $path = $request->file('media')->store('media','public');
        $image_path = public_path('upload'). '/'.$path;
        header('content-type:text/html;charset=utf8');
        $ch = curl_init();
        $data = array('media' => new \CURLFile($image_path));
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" .
            $access_token . "&type=image");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        $file_info = json_decode($result,true);
        if(isset($file_info['media_id'])){
            $filesModel = new Files();
            $filesModel ->insert([
                'media_id' => $file_info['media_id'],
                'url'      => $path,
                'create_time' => date('Y-m-d H:i:s')
                ]);
        }
        return $result;
    }

}