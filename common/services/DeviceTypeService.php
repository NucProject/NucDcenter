<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:47
 */

namespace common\services;


use common\components\ModelSaveFailedException;
use common\models\NucDeviceField;
use common\models\NucDeviceType;

class DeviceTypeService
{
    /**
     * @param $params
     * @return NucDeviceType
     * @throws ModelSaveFailedException
     */
    public static function createDeviceType($params)
    {
        $type = new NucDeviceType();
        $type->setAttributes(($params));
        if ($type->save()) {
            return $type;
        } else {
            throw new ModelSaveFailedException($type->getErrors());
        }
    }

    /**
     * @return static[] with NucDeviceField
     */
    public static function getDeviceTypeList()
    {
        return NucDeviceType::find()->with('fields')->where([])->all();
    }

    public static function syncDeviceTypes()
    {

    }

    /**
     * @param $typeKey
     * @return NucDeviceType
     */
    public static function getDeviceType($typeKey)
    {
        return NucDeviceType::findOne(['type_key' => $typeKey]);
    }

    /**
     * @param $deviceTypes
     * TODO: 得考虑网络状况
     * @throws ModelSaveFailedException
     * @return bool
     */
    public static function flushDeviceTypesToLocalDataCenter($deviceTypes)
    {
        // 可能不删除比较好
        NucDeviceType::deleteAll([]);

        foreach ($deviceTypes as $deviceType)
        {
            $type = new NucDeviceType();
            $type->setAttributes($deviceType);
            if ($type->save()) {
                // 更新类型对应的字段
                $field = new NucDeviceField();
                $field->setAttributes($deviceTypes['fields']);
                if (!$field->save()) {
                    throw new ModelSaveFailedException($field->getErrors());
                }
            } else {
                throw new ModelSaveFailedException($type->getErrors());
            }
        }
        return true;
    }
}