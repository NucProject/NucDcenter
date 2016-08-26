<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NucDeviceType]].
 *
 * @see NucDeviceType
 */
class NucDeviceTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NucDeviceType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NucDeviceType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
