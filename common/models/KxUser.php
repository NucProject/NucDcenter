<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_user".
 *
 * @property integer $user_id
 * @property string $username
 * @property string $password_hash
 * @property integer $password_modified
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class KxUser extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password_modified', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'password_hash'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password_hash' => '密码HASH值',
            'password_modified' => '密码变更次数',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
        ];
    }
}
