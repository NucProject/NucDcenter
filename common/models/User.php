<?php
namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * User component
 *
 */
class User extends KxUser implements IdentityInterface
{
    const StatusInactive = 0;

    const StatusActive = 1;

    private $isLoggedIn = false;

    private $roleId = false;

    public function init()
    {
        parent::init();
    }

    /**
     * @param $username
     * @return \common\models\User
     */
    public static function getUserByName($username)
    {
        return User::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getRoleName()
    {
        return $this->roleId;
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function setLogin()
    {
        $this->isLoggedIn = true;
    }
    /**
     * @return array
     */
    public function userInfo()
    {
        return [
            'name' => $this->username,
            'user_id' => $this->user_id
        ];
    }

    ///////////////////////////////////////////////////////////////////////////
    // implements IdentityInterface
    /**
     * Finds an identity by the given ID.
     * @param string|integer $userId the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($userId) //: \common\models\User
    {
        $user = User::findOne($userId);
        if ($user)
        {
            $relation = KxAdminRelation::find()->where(['user_id' => $userId])->one();
            $user->roleId = $relation->role_id;
        }

        return $user;
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Do NOT use token by now.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->user_id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {

    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {

    }
}
