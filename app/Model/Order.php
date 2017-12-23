<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    //
    use SoftDeletes;
    protected $table = 'order'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

}
