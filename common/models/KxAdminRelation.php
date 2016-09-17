<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_admin_relation".
 *
 * @property integer $relation_id
 * @property integer $user_id
 * @property integer $role_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class KxAdminRelation extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_admin_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(KxUser::className(), ['user_id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relation_id' => 'Relation ID',
            'user_id' => 'User ID',
            'role_id' => 'Role ID',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return KxAdminRelationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KxAdminRelationQuery(get_called_class());
    }
}
