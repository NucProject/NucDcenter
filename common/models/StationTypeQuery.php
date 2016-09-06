<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NucStation]].
 *
 * @see NucStation
 */
class StationTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NucStation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NucStation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
