<?php

namespace App\Services;

use App\Models\Account;

class WeChat
{
    public function get_access_token($id)
    {
        $accountModel =  new Account();
        return $accountModel ->get_access_token($id);
    }
}
