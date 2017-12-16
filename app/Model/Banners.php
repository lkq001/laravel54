<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Banners extends Model
{
    //
    use SoftDeletes;
    protected $table = 'banners'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function getTagAttribute($value)
    {
        return 123;
        return config('common.URL.image') . $value;
    }
}
