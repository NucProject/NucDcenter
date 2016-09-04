<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 0:13
 *
 */

namespace frontend\controllers;


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

    }

    /**
     * @ajax
     * @comment 角色增加
     */
    public function actionDoAdd()
    {

    }

    /**
     * @ajax
     * @comment 角色删除
     */
    public function actionRemove()
    {

    }

    /**
     * @page
     * @comment 角色节点
     */
    public function actionNodes()
    {

    }

    /**
     * @page
     * @comment 角色菜单
     */
    public function actionMenus()
    {

    }

    /**
     * @ajax
     * @comment 角色删除
     */
    public function actionMenusUpdate()
    {

    }
}