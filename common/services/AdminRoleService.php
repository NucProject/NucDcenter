<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 13:14
 *
 */

namespace common\services;


use common\components\ModelSaveFailedException;
use common\models\KxAdminRole;

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
        if ($role->save()) {
            return $role;
        } else {
            throw new ModelSaveFailedException($role->getErrors());
        }

    }
}