<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/28
 * Time: 21:05
 */

namespace common\components;

use yii;

class AccessControl extends \yii\filters\AccessControl
{
    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        $user = Yii::$app->user;
        $model = $user->getIdentity();

        if ($user->isGuest) {
            $exception = new AccessForbiddenException('您还没有登录，或者登录已经失效，请重新登录');
            throw $exception;
        }

        if (!$this->allowAccess($model, $action)) {
            $exception = new AccessForbiddenException('您没有权限访问该页面，需要帮助请联系管理员');
            throw $exception;
        }

        return true;
    }

    /**
     * @param $model \common\models\User
     * @param $action
     * @return bool
     */
    private function allowAccess($model, $action)
    {
        $controllerName = $action->controller->id;
        $actionName = $action->id ?: 'index';


        $roleName = $model->getRoleName();
        return true;
    }
}