<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/17
 * Time: 22:52
 */

namespace common\services;


use common\models\KxAdminRelation;

class AdminUserService
{
    /**
     * @param $params
     * @return array|bool|int
     */
    public static function addAdminUser($params)
    {
        $username = $params['username'];
        $result = UserService::addUser($username, false);

        if ($result instanceof \common\models\KxUser)
        {
            $roleId = $params['roleId'];
            $relation = new KxAdminRelation();
            $relation->user_id = $result->user_id;
            $relation->role_id = $roleId;
            if ($relation->save())
            {
                return $result;
            }
            else
            {
                return $relation->getErrors();
            }
        }

        return $result;
    }

}