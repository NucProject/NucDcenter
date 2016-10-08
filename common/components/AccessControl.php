<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/28
 * Time: 21:05
 */

namespace common\components;

use common\models\KxAdminRoleAccess;
use yii;

class AccessControl extends \yii\filters\AccessControl
{
    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        $controllerName = $action->controller->id;
        $actionName = $action->id ?: 'index';

        if ($controllerName == 'send' &&
            ($actionName == 'data' || $actionName == 'mobile-data')) {
            // 设备发送数据，不校验用户和权限
            // 未来不排除校验token, 格式等
            return true;
        }


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

        if ($controllerName == 'site' &&
            ($actionName == 'index' || $actionName == 'login' || $actionName == 'error')) {

            return true;
        }

        $roleId = $model->getRoleName();
        if ($roleId)
        {
            if ($model->isSuper())
            {
                // 我们需要把roleId=1的角色设置为超级管理员
                return true;
            }
            $access = KxAdminRoleAccess::find()
                ->with('node')
                ->where(['role_id' => $roleId])
                ->asArray()
                ->all();

            foreach ($access as $item)
            {
                $node = $item['node'];
                if ($node['controller'] == $controllerName &&
                    $node['action'] == $actionName) {
                    // 暂时不处理params的问题
                    return true;
                }
            }
        }
        return false;
    }
}