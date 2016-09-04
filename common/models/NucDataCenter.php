<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_data_center".
 *
 * @property integer $center_id
 */
class NucDataCenter extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_data_center';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['center_id'], 'required'],
            [['center_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'center_id' => 'Center ID',
        ];
    }

    /**
     * @inheritdoc
     * @return NucDataCenterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucDataCenterQuery(get_called_class());
    }
}
