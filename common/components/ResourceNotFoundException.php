<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/2 18:03
 *
 */

namespace common\components;


use yii\base\UserException;

class ResourceNotFoundException extends UserException
{
    public $reason = false;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }
}