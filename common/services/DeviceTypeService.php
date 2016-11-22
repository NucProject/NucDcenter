<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:47
 */

namespace common\services;


use common\components\AccessForbiddenException;
use common\components\ModelSaveFailedException;
use common\models\NucDeviceField;
use common\models\NucDeviceType;

class DeviceTypeService
{
    /**
     * @param $params
     * @param $fields
     * @return NucDeviceType
     * @throws ModelSaveFailedException
     */
    public static function createDeviceType($params, $fields)
    {
        $type = new NucDeviceType();
        $type->setAttributes($params);
        if ($type->save()) {

            self::addDeviceTypeFields($type, $fields);
            return $type;
        } else {
            throw new ModelSaveFailedException($type->getErrors());
        }
    }

    /**
     * @param $type     NucDeviceType
     * @param $fields   array
     */
    private static function addDeviceTypeFields($type, $fields)
    {
        $typeKey = $type->type_key;
        foreach ($fields as $field)
        {
            $fieldEntry = new NucDeviceField();
            $fieldEntry->type_key = $typeKey;
            $fieldEntry->field_name = $field['fieldName'];
            $fieldEntry->field_display = $field['fieldTitle'];
            $fieldEntry->field_desc = $field['fieldDesc'];
            $fieldEntry->field_value_type = $field['fieldValueType'];
            $fieldEntry->field_unit = $field['fieldUnit'];
            $fieldEntry->display_flag = $field['fieldDisplayFlag'];
            $fieldEntry->save();
        }
    }

    /**
     * @param $typeKey
     * @return NucDeviceField
     */
    public static function getDisplayField($typeKey)
    {
        $field = NucDeviceField::find()
            ->where(['type_key' => $typeKey])
            ->andWhere(['display_flag' => 1])
            ->one();
        return $field;
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
     * @throws
     */
    public static function getDeviceType($typeKey)
    {
        $deviceType = NucDeviceType::find()->with('fields')->where(['type_key' => $typeKey])->one();
        if (!$deviceType) {
            throw new AccessForbiddenException("设备类型不存在");
        }
        return $deviceType;
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