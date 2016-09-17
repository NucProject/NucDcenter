<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/27
 * Time: 13:39
 */

namespace common\services;


use common\models\User;

class UserService
{
    /**
     * @param $username
     * @param $password
     * 如果密码为空，则初始化为与用户名相同的字符串，登录后请尽快修改
     * @return \common\models\User
     */
    public static function addUser($username, $password=false)
    {
        if (!$password) {
            $password = $username;
        }

        $user = new User();
        $user->username = $username;
        $user->password_hash = self::getPasswordHash($password);
        $user->password_modified = 0;
        if ($user->save())
        {
            return $user;
        }
        else
        {
            $errors = $user->getErrors();
            return $errors;
        }
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

    /**
     * @param $username
     * @param $password
     * @return \common\models\User
     */
    public static function login($username, $password)
    {
        $user = User::getUserByName($username);
        if (!$user) {
            return false;
        }

        if (!self::isValidPassword($password, $user->password_hash)) {
            return false;
        }
        $user->setLogin();
        return $user;
    }

    public static function logout($userId)
    {

    }

    public static function isValidPassword($password, $passwordHash)
    {
        if ($passwordHash) {
            list($hash, $random) = preg_split('/:/', $passwordHash);
            return md5($password . "$random") === $hash;
        }
        return false;
    }

    public static function getPasswordHash($password)
    {
        $random = rand(100, 999);
        return md5($password . "$random") . ":{$random}";
    }

}