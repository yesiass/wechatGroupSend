<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 自动回复
 * Class FollowReply
 * @package App\Models
 */
class FollowReply extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'account_id';
    public $timestamps = false;
    protected $table   = 'follow_reply';
}
