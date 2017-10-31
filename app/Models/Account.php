<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 账号model
 * Class Account
 * @package App\Models
 */
class Account extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    protected $table   = 'account';

    protected $hidden = [
        'passwd'
    ];

    /**
     * 获取账号列表
     * @return mixed
     */
    public function getList()
    {
        return $this->select('account','id','appid') ->orderBy('id','desc') ->paginate(25);
    }

    /**
     * 获取详细信息
     * @param $id
     * @return mixed
     */
    public function getDetails($id)
    {
        return $this
                ->select([
                    'id','account','passwd','appid','appsecret'
                ])
                ->find($id);
    }

    /**
     * 获取账号access_token
     * @param $id
     * @return bool|mixed|string
     */
    public function get_access_token($id)
    {
        $data  = $this ->find($id);
        $appid = $data->appid;
        $appsecret = $data->appsecret;
        $access_token = $this ->where('appid','=',$appid)
            ->where('normal_expires','>',time())
            ->value('normal_access_token');
        if($access_token){
            $accessToken = $access_token;
        }else{
            $accessToken = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret.'');
            $accessToken = json_decode($accessToken, true);
            if (isset($accessToken['access_token'])){
                $accessToken = $accessToken['access_token'];
                $this->where('appid', $appid)
                    ->update([
                        'normal_access_token' => $accessToken,
                        'normal_expires' => time()+7200,
                    ]);
            }else{
                $accessToken = '';
            }

        }
        return $accessToken;
    }
}
