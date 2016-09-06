<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_station".
 *
 * @property integer $station_id
 * @property integer $center_id
 * @property string $station_key
 * @property string $station_name
 * @property string $station_desc
 * @property string $station_pic
 * @property integer $station_type
 * @property string $owner_lead
 * @property string $owner_org
 * @property string $builder_org
 * @property string $ops_org
 * @property string $completion_date
 * @property string $lng
 * @property string $lat
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
            [['center_id', 'station_type', 'status'], 'integer'],
            [['completion_date', 'create_time', 'update_time'], 'safe'],
            [['lng', 'lat'], 'number'],
            [['station_key', 'station_name'], 'string', 'max' => 32],
            [['station_desc', 'station_pic', 'owner_lead', 'owner_org', 'builder_org', 'ops_org'], 'string', 'max' => 255],
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
            'station_key' => '自动站唯一KEY',
            'station_name' => '自动站名称',
            'station_desc' => '自动站描述',
            'station_pic' => '自动站图片PATH',
            'station_type' => '自动站移动属性',
            'owner_lead' => '负责人姓名',
            'owner_org' => '业主单位名称',
            'builder_org' => '建设单位名称',
            'ops_org' => '运维单位名称',
            'completion_date' => '建成日期',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return NucStationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucStationQuery(get_called_class());
    }
}
