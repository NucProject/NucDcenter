<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_recommend".
 *
 * @property integer $recommend_id
 * @property string $recommend_title
 * @property string $recommend_desc
 * @property string $recommend_image
 * @property string $expired_time
 * @property string $create_time
 * @property string $update_time
 */
class KxRecommend extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_recommend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expired_time', 'create_time', 'update_time'], 'safe'],
            [['recommend_title'], 'string', 'max' => 255],
            [['recommend_desc'], 'string', 'max' => 1024],
            [['recommend_image'], 'string', 'max' => 655],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recommend_id' => 'Recommend ID',
            'recommend_title' => 'Recommend Title',
            'recommend_desc' => 'Recommend Desc',
            'recommend_image' => 'Recommend Image',
            'expired_time' => 'Expired Time',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return KxRecommendQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KxRecommendQuery(get_called_class());
    }
}
