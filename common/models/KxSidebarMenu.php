<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_sidebar_menu".
 *
 * @property integer $menu_id
 * @property string $menu_name
 * @property string $menu_desc
 * @property integer $menu_order
 * @property integer $role_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
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
            [['menu_order', 'role_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['menu_name', 'menu_desc'], 'string', 'max' => 255],
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
            'menu_desc' => 'Menu Desc',
            'menu_order' => 'Menu Order',
            'role_id' => 'Role ID',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
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
