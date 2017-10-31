<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * 群发
 * Class GroupSend
 * @package App\Models
 */
class InterfaceLog extends Authenticatable
{
    use Notifiable;
    //protected $primaryKey = 'account_id';
    public $timestamps = false;
    protected $table   = 'call_interface_log';

    public function get_logs()
    {
        return $this
                ->select('call_interface_log.*','account.account')
                ->join('account','account.id','call_interface_log.account_id')
                ->orderBy('call_interface_log.id','desc')
                ->paginate(25);
    }
}
