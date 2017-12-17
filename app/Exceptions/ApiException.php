<?php
/**
 *
 *
 * Created by PhpStorm.
 * User: likeqin
 * Date: 2017/12/16
 * Time: 23:42
 * author 李克勤
 */

namespace App\Exceptions;

class ApiException extends \Exception
{
    function __construct($code = '200', $msg = '', $errorCode = '')
    {
        parent::__construct($code);
        parent::__construct($msg);
        parent::__construct($errorCode);
    }
}