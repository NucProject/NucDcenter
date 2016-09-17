<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/17
 * Time: 22:41
 */

namespace frontend\controllers;

use yii;
use common\components\Helper;
use common\components\ModelSaveFailedException;
use common\services\AdminRoleService;
use common\services\AdminUserService;

class AdminUserController extends BaseController
{
    /**
     * @page
     * @comment 全部用户列表
     * 不区分角色
     */
    public function actionIndex()
    {

    }

    /**
     * @page
     * @comment 添加用户
     */
    public function actionAdd()
    {
        $data = [];
        $data['roles'] = AdminRoleService::getAdminRoles();
        $data['doAddUrl'] = 'index.php?r=admin-user/do-add';   // [1]
        return parent::renderPage('add.tpl', $data, ['with' => ['dialog']]);
    }

    /**
     * [1]
     * @ajax
     * @comment 添加用户
     */
    public function actionDoAdd()
    {
        $roleId = Helper::getPost('roleId', ['default' => 0]);

        if ($roleId == 0) {
            return parent::error([], -1);
        }

        $params = [
            'username'    => Helper::getPost('username', ['required' => true]),
            'roleId'       => $roleId
        ];

        $result = AdminUserService::addAdminUser($params);
        if ($result instanceof \common\models\KxUser)
        {
            Yii::$app->session->setFlash('add-station', 'success');
            Yii::$app->response->redirect('index.php?r=admin-user/index');
        }
        else
        {
            throw new ModelSaveFailedException($result);
        }
    }
}