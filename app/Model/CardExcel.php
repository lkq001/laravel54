<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardExcel extends Model
{
    //
    use SoftDeletes;
    protected $table = 'card_excel'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];
}
