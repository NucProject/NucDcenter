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
            'station_id' => 'Station ID',
            'center_id' => 'Center ID',
            'station_key' => 'Station Key',
            'station_name' => 'Station Name',
            'station_desc' => 'Station Desc',
            'station_pic' => 'Station Pic',
            'station_type' => 'Station Type',
            'owner_lead' => 'Owner Lead',
            'owner_org' => 'Owner Org',
            'builder_org' => 'Builder Org',
            'ops_org' => 'Ops Org',
            'completion_date' => 'Completion Date',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
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
