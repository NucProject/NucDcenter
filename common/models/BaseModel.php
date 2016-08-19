<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/19
 * Time: 22:41
 */

namespace common\models;
use \yii\db\ActiveRecord;
use \yii\db\Expression;
use \yii\behaviors\AttributeBehavior;
use \yii\behaviors\TimestampBehavior;

class BaseModel extends ActiveRecord
{
    /**
     * @return array
     * Each table should have the following fields:
     *     status, create_time, update_time
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'status',
                ],
                'value' => function ($event) { return 1; },
            ]
        ];
    }
}