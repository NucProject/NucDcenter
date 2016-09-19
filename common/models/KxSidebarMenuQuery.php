<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[KxSidebarMenu]].
 *
 * @see KxSidebarMenu
 */
class KxSidebarMenuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return KxSidebarMenu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return KxSidebarMenu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
