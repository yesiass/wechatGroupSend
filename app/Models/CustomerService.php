<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 账号关注定时消息
 * Class CustomerService
 * @package App\Models
 */
class CustomerService extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * 获取客服列表（未使用）
     * @param $id
     * @return array
     */
    public function getList($id)
    {
        $accountModel = new Account();
        $access_token = $accountModel ->get_access_token($id);
        $data = file_get_contents('https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token='.$access_token);
        $kf_list = json_decode($data,true);
        if(isset($kf_list['kf_list'])){
            return $kf_list['kf_list'];
        }else{
            return [];
        }
    }
}
