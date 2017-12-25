<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CardUse extends Model
{
    //
    use SoftDeletes;
    protected $table = 'card_use'; //表名
    protected $primaryKey = 'id'; //主键
    protected $datas = ['deleted_at'];

    public function cards()
    {
        return $this->belongsTo('App\Model\Cards','card_id', 'id');
    }

}
