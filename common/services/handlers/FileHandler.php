<?php

namespace common\services\handlers;
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2017/3/10
 * Time: 23:30
 */
abstract class FileHandler
{
    /**
     * @param $fileType
     * @return FileHandler
     */
    public static function getHandler($fileType)
    {
        if ($fileType == 'hpge')
        {
            return new HpgeReportFileHandler();
        }
    }

    public static function checkPath($path)
    {
        $join = 'upload';
        $parts = explode('/', $path);
        foreach ($parts as $part)
        {
            $join = $join . '/' . $part;
            if (!file_exists($join))
            {
                mkdir($join);
            }
        }

        return $join;
    }

    /**
     * @param \yii\web\UploadedFile $file
     */
    public abstract function save($file);
}