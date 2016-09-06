<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/6 20:35
 *
 */

namespace common\components;


use yii\base\UserException;

class BadArgumentException extends UserException
{
    public $reason = false;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }
}