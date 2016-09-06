<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/6 16:38
 *
 */

namespace common\components;

use yii\base\UserException;

class ModelSaveFailedException extends UserException
{
    public $errors = false;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }
}