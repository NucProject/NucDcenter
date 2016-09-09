<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 0:13
 *
 */

namespace frontend\controllers;

use common\components\Helper;
use yii;
use common\services\AdminRoleService;

class AdminRoleController extends BaseController
{
    /**
     * @page
     * @comment 角色列表
     */
    public function actionIndex()
    {
        $data = [];
        $data['roles'] = AdminRoleService::getAdminRoles();

        return parent::renderPage('list.tpl', $data, []);

    }

    /**
     * @page
     * @comment 角色增加
     */
    public function actionAdd()
    {
        $data = [];
        $data['doAddUrl'] = 'index.php?r=admin-role/add';   // [1]
        return parent::renderPage('add.tpl', $data, []);
    }

    /**
     * [1]
     * @ajax
     * @comment 角色增加
     */
    public function actionDoAdd()
    {
        $params = [
            'role_name'    => Helper::getPost('roleName', ['required' => true]),
            'role_desc'    => Helper::getPost('roleDesc', ['default' => '']),
        ];

        if (AdminRoleService::addRole($params))
        {
            Yii::$app->session->setFlash('add-station', 'success');
            Yii::$app->response->redirect('index.php?r=admin-role/index');
        }
    }

    /**
     * @ajax
     * @comment 角色禁用
     */
    public function actionDisable()
    {
        $roleId = Yii::$app->request->get('roleId', 0);
        if ($roleId > 0)
        {
            $disable = Yii::$app->request->get('disable', 1);
            $role = AdminRoleService::disableRole($roleId, $disable);
            if ($role) {
                return parent::result(['roleId' => $role->role_id]);
            }
        }
        return parent::error([], -1);
    }

    /**
     * @page
     * @comment 角色节点
     */
    public function actionNodes()
    {
        $roleId = Yii::$app->request->get('roleId', 0);

        $nodes = AdminRoleService::getNodesByRole($roleId);

        $data = [
            'roleId'    => $roleId,
            'nodes'     => $nodes
        ];

        return parent::renderPage('nodes.tpl', $data, []);
    }

    /**
     * @page
     * @comment 角色菜单
     */
    public function actionMenus()
    {
        $roleId = Yii::$app->request->get('roleId', 0);

        $menus = AdminRoleService::getMenusByRole($roleId);

        $data = [
            'roleId' => $roleId,
            'menus' => $menus
        ];

        return parent::renderPage('menus.tpl', $data, []);
    }

    /**
     * @ajax
     * @comment 角色删除
     */
    public function actionMenusUpdate()
    {
        $roleId = Yii::$app->request->post('roleId', 0);
        if ($roleId > 0) {
            $menus = Yii::$app->request->post('menus');

            if (AdminRoleService::flushMenus($roleId, $menus))
            {
                return parent::result(['roleId' => $roleId]);
            }

        }
        return parent::error([], -1);
    }
}