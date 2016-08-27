<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/27
 * Time: 13:39
 */

namespace common\services;


class UserService
{
    /**
     * @param $username
     * @return int
     */
    public static function addUser($username)
    {
        $userId = 0;
        return $userId;
    }

    public static function disableUser($userId)
    {

    }

    public static function changePassword($userId, $password)
    {

    }

    /**
     * @param $userId
     * @param $params
     */
    public static function changeProperty($userId, $params)
    {

    }

    public static function login($username, $password)
    {

    }

    public static function logout($userId)
    {

    }

}