<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NucDeviceAlertSetting]].
 *
 * @see NucDeviceAlertSetting
 */
class NucDeviceAlertSettingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NucDeviceAlertSetting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NucDeviceAlertSetting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
