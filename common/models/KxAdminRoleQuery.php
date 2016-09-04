<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[KxAdminRole]].
 *
 * @see KxAdminRole
 */
class KxAdminRoleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return KxAdminRole[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return KxAdminRole|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
