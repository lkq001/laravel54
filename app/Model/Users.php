<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Users extends Model
{
    //
    use SoftDeletes;
    protected $table = 'users'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];
    protected $fillable = ['openid'];

    public static function getByOpenId($openid)
    {
        $user = self::where('openid', $openid)->first();

        return $user;
    }

    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

}
