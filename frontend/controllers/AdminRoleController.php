<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 0:13
 *
 */

namespace frontend\controllers;

use common\components\Helper;
use common\components\ModelSaveFailedException;
use common\models\KxAdminRoleAccess;
use common\models\KxAdminRoleAccessQuery;
use common\services\SidebarMenuService;
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
        $data['doAddUrl'] = 'index.php?r=admin-role/do-add';   // [1]
        return parent::renderPage('add.tpl', $data, ['with' => ['dialog']]);
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
     * @param $roleId
     * @return string
     */
    public function actionUsers($roleId)
    {
        // 每一个关系存在一个唯一的用户(目前一个用户只能有一个角色)
        $relations = AdminRoleService::getUsersByRole($roleId);

        $data = [
            'roleId'        => $roleId,
            'relations'     => $relations
        ];

        return parent::renderPage('users.tpl', $data, []);
    }

    /**
     * @page
     * @comment 角色节点
     */
    public function actionNodes()
    {
        $roleId = Yii::$app->request->get('roleId', 0);

        $results = AdminRoleService::getNodesByRole($roleId);
        $menus = SidebarMenuService::listMenuByRole($roleId);

        $nodes = $results['nodes'];
        $access = $results['access'];

        foreach ($nodes as &$node)
        {
            $node['pageUrl'] = $this->makeUrl($node);
            $nodeId = $node['node_id'];
            $node['accessAllowed'] = false;
            $node['menu_id'] = 0;
            if (array_key_exists($nodeId, $access))
            {
                $node['accessAllowed'] = true;
                $node['menu_id'] = $access[$nodeId]['menu_id'];
            }

        }
        $data = [
            'roleId'    => $roleId,
            'nodes'     => $nodes,
            'menus'     => $menus
        ];

        return parent::renderPage('nodes.tpl', $data, []);
    }

    public function actionUpdateNodes()
    {
        $roleId = Yii::$app->request->post('roleId');
        $accessMap = Yii::$app->request->post('f');

        $accesses = KxAdminRoleAccess::find()->where(['role_id' => $roleId])->all();
        foreach ($accesses as $item)
        {
            // 通过删除之前的设定, 重新设定
            $item->delete();
        }

        // 更新为新的访问设定
        foreach ($accessMap as $nodeId => $accessItem)
        {
            if ($accessItem['accessAllowed'] == 'on')
            {
                $access = new KxAdminRoleAccess();
                $access->node_id = $nodeId;
                $access->role_id = $roleId;
                $access->menu_id = $accessItem['menuId'];
                if (!$access->save()) {
                    throw new ModelSaveFailedException('');
                }
            }
        }

        Yii::$app->response->redirect('index.php?r=admin-role/index');
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


    private function makeUrl($node)
    {
        $controller = $node['controller'];
        $action = $node['action'];
        $params = '';
        if ($node['param0']) {
            $params = "&{$node['param0']}={$node['value0']}";
        }
        if ($node['param1']) {
            $params = "&{$node['param1']}={$node['value1']}";
        }
        return "$controller/$action" . $params;
    }
}