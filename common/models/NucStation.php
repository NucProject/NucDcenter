<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_station".
 *
 * @property integer $station_id
 * @property integer $center_id
 * @property string $station_name
 * @property string $station_desc
 * @property integer $movable
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class NucStation extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_station';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['center_id', 'movable', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['station_name'], 'string', 'max' => 32],
            [['station_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'station_id' => '自动站ID',
            'center_id' => '所在数据中心ID',
            'station_name' => '自动站名称',
            'station_desc' => '自动站描述',
            'movable' => '自动站移动属性',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
        ];
    }
}
