<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 定时自动回复
 * Class FollowTick
 * @package App\Models
 */
class FollowTick extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'account_id';
    public $timestamps = false;
    protected $table   = 'follow_tick';
}
