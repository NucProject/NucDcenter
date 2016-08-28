<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/28
 * Time: 22:56
 */

namespace common\components;


use yii\web\ForbiddenHttpException;

class AccessForbiddenException extends ForbiddenHttpException
{

    public function __construct($userInfo)
    {
        parent::__construct('AccessForbidden', 403, null);
        $this->userInfo = $userInfo;
    }
}