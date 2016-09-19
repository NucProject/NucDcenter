<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/8/31 19:47
 *
 */

namespace common\services;


use common\models\KxSidebarMenu;

class SidebarMenuService
{
    public static function listMenuByRole($roleId)
    {
        return KxSidebarMenu::find()->where(['role_id' => $roleId])->asArray()->all();
    }
}