<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/cloud-admin.min.css',
        'css/themes/default.min.css', /* MUST after cloud-admin.min.css */
        'css/flags/flags.min.css',
        'js/jquery-ui-1.10.3.custom/css/custom-theme/jquery-ui-1.10.3.custom.min.css',
        'css/inbox.css',
        'css/responsive.min.css',
        'font-awesome/fonts/fontawesome-webfont.woff',
        'font-awesome/css/font-awesome.min.css',
        'css/fonts.css'
        //// 'css/print.css', * CAN NOT LOAD THIS CSS
    ];

    public $js = [
        'js/jquery/jquery-2.0.3.min.js',
        'js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js',
        'bootstrap-dist/js/bootstrap.min.js',
        'js/jquery-cookie/jquery.cookie.min.js',
        'js/jquery-slimscroll-1.3.0/jquery.slimscroll.min.js',
        'js/jquery-slimscroll-1.3.0/slim.scroll.horizontal.min.js',
        'js/script.js',
        'js/active-web/config.js',
        'js/active-web/classes.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
    }
}
