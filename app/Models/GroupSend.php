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
class GroupSend extends Authenticatable
{
    use Notifiable;
    //protected $primaryKey = 'account_id';
    public $timestamps = false;
    protected $table   = 'group_send';

    public function get_task_log($id)
    {
        return DB::table('task_logs')
            ->where('task_id',$id)
            ->orderBy('id','desc')
            ->paginate(25);
    }
}
