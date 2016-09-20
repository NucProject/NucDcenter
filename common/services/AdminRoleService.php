<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 13:14
 *
 */

namespace common\services;


use common\components\BadArgumentException;
use common\components\ModelSaveFailedException;
use common\models\KxAdminNode;
use common\models\KxAdminRelation;
use common\models\KxAdminRole;
use common\models\KxAdminRoleAccess;
use common\models\KxSidebarMenu;

class AdminRoleService
{
    /**
     * @return static[]
     */
    public static function getAdminRoles()
    {
        return KxAdminRole::find()->where(['status' => 1])->all();
    }

    /**
     * @param $params
     * @return KxAdminRole
     * @throws ModelSaveFailedException
     */
    public static function addRole($params)
    {
        $role = new KxAdminRole();
        $role->setAttributes($params);
        $role->status = 1;

        if ($role->save()) {
            return $role;
        } else {
            throw new ModelSaveFailedException($role->getErrors());
        }

    }

    /**
     * @param $roleId
     * @param $disable
     * @return null|KxAdminRole
     * @throws BadArgumentException
     * @throws ModelSaveFailedException
     */
    public static function disableRole($roleId, $disable=true)
    {
        $role = KxAdminRole::findOne($roleId);
        if ($role) {
            $role->enabled = $disable ? 0 : 1;  // ???
            if ($role->save()) {
                return $role;
            } else {
                throw new ModelSaveFailedException($role->getErrors());
            }
        }
        throw new BadArgumentException('');
    }


    /**
     * @param $roleId
     * @return array
     * @throws BadArgumentException
     */
    public static function getUsersByRole($roleId)
    {
        $users = [];
        if (self::checkRoleId($roleId))
        {
            $users = KxAdminRelation::find()
                ->with('user')
                ->where(['role_id' => $roleId])
                ->asArray()
                ->all();
        }

        return $users;
    }

    /**
     * @param $roleId
     * @return array
     * @throws BadArgumentException
     */
    public static function getNodesByRole($roleId)
    {
        $nodes = [];
        if (self::checkRoleId($roleId))
        {
            $nodes = KxAdminNode::find()->where([])->asArray()->all();

            $access = KxAdminRoleAccess::find()
                ->where(['role_id' => $roleId])->asArray()->all();

            $accessMap = [];
            foreach ($access as $entry)
            {
                $accessMap[$entry['node_id']] = $entry;
            }
        }

        return ['nodes' => $nodes, 'access' => $accessMap];
    }

    /**
     * @param $roleId
     * @return array
     * @throws BadArgumentException
     */
    public static function getMenusByRole($roleId)
    {
        $menus = [];
        if (self::checkRoleId($roleId))
        {
            return KxSidebarMenu::find()->where(['role_id' => $roleId])->all();
        }

        return $menus;
    }


    private static function checkRoleId($roleId)
    {
        if (is_numeric($roleId) && $roleId > 0)
        {
            return true;
        }
        $reason = '无效的RoleId';
        throw new BadArgumentException($reason);
    }

    /**
     * @param $roleId
     * @param $menus
     * @return bool
     * @throws ModelSaveFailedException
     */
    public static function flushMenus($roleId, $menus)
    {
        // $exists = KxSidebarMenu::find()->where(['role_id' => $roleId])->all();
        // foreach ($exists as $exist) { $exist->delete(); }
        foreach ($menus as $menu)
        {
            if ($menu['menuId'] == 0) {
                $sidebarMenu = new KxSidebarMenu();
            } else {
                $sidebarMenu = KxSidebarMenu::findOne($menu['menuId']);
            }

            $sidebarMenu->role_id = $roleId;
            $sidebarMenu->menu_name = $menu['name'];
            if (!$sidebarMenu->save())
            {
                throw new ModelSaveFailedException($sidebarMenu->getErrors());
            }
        }
        return true;
    }
}