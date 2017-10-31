<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 微信图片本地存贮类
 * Class Files
 * @package App\Models
 */
class Files extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    protected $table   = 'files';
}
