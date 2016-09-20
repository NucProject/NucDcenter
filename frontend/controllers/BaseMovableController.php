<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 9:59
 */

namespace frontend\controllers;


use yii\web\Controller;

class BaseMovableController extends Controller
{

    public function renderPage()
    {

    }

    /**
     * @param $data
     * @return bool exit() in fact
     */
    public static function result($data) {
        return static::retVal($data, 0);
    }

    /**
     * @param $data
     * @param $errorCode
     * @return bool exit() in fact
     */
    public static function error($data, $errorCode) {
        return static::retVal($data, $errorCode);
    }

    /**
     * @param $data
     * @param $errorCode
     * @return bool exit() in fact
     */
    private static function retVal($data, $errorCode) {
        exit(json_encode(['error' => $errorCode, 'data' => $data]));
        return false;
    }
}