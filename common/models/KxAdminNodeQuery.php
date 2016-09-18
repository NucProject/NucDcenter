<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[KxAdminNode]].
 *
 * @see KxAdminNode
 */
class KxAdminNodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return KxAdminNode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return KxAdminNode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
