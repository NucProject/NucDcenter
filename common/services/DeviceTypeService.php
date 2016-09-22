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
        $type->setAttributes($params);
        if ($type->save()) {
            return $type;
        } else {
            throw new ModelSaveFailedException($type->getErrors());
        }
    }

    /**
     * @param $condition
     * @return static[] with NucDeviceField
     */
    public static function getDeviceTypeList($condition=[])
    {
        return NucDeviceType::find()
            ->with('fields')
            ->where($condition)
            ->all();
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
        return NucDeviceType::find()->where(['type_key' => $typeKey])->one();
    }

    /**
     * @param $deviceTypes
     * TODO:
     * @throws ModelSaveFailedException
     * @return bool
     */
    public static function flushDeviceTypesToLocalDataCenter($deviceTypes)
    {
        //
        NucDeviceType::deleteAll([]);

        foreach ($deviceTypes as $deviceType)
        {
            $type = new NucDeviceType();
            $type->setAttributes($deviceType);
            if ($type->save()) {
                //
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