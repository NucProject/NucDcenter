<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[KxAdminRoleAccess]].
 *
 * @see KxAdminRoleAccess
 */
class KxAdminRoleAccessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return KxAdminRoleAccess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return KxAdminRoleAccess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
