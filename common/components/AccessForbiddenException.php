<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/28
 * Time: 22:56
 */

namespace common\components;


use yii\base\UserException;

class AccessForbiddenException extends UserException
{
    public $reason = false;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }
}