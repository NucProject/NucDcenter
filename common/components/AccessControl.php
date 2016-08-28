<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/28
 * Time: 21:05
 */

namespace common\components;

use yii;
use common\models\User;
use yii\web\ForbiddenHttpException;

class AccessControl extends \yii\filters\AccessControl
{
    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        Yii::$app->session->open();
        $userInfo = Yii::$app->session->get('user');
        if ($userInfo &&
            is_array($userInfo) &&
            array_key_exists('user_id', $userInfo))
        {
            $userId = $userInfo['user_id'];

            $user = User::findIdentity($userId);
            if ($user)
            {
                return true;
            }
        }

        $exception = new AccessForbiddenException($userInfo);

        throw $exception;
    }
}