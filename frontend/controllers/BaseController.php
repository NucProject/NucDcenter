<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/19
 * Time: 20:01
 */

namespace frontend\controllers;

use yii;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param $page
     * @param $data
     * @return string
     * ����ᴦ��һЩģ���й��õĲ���
     */
    public function renderPage($page, $data=array())
    {
        return $this->render($page, $data);
    }
}