<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_sidebar_menu".
 *
 * @property integer $menu_id
 * @property string $menu_name
 * @property integer $role_id
 * @property integer $status
 * @property string $create_time
 * @property string $last_modified
 */
class KxSidebarMenu extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_sidebar_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'status'], 'integer'],
            [['status'], 'required'],
            [['create_time', 'last_modified'], 'safe'],
            [['menu_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'menu_name' => 'Menu Name',
            'role_id' => 'Role ID',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'last_modified' => 'Last Modified',
        ];
    }

    /**
     * @inheritdoc
     * @return KxSidebarMenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KxSidebarMenuQuery(get_called_class());
    }
}
