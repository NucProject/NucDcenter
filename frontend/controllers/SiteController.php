<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use common\services\StationService;
use common\services\UserService;
use common\components\AccessForbiddenException;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        // TODO: Merge from parent::behaviors()
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testMe' : null,
                'backColor'       => 0x5e87b0,    //背景颜色
                'maxLength'       => 4,   //最大显示个数
                'minLength'       => 4,   //最少显示个数
                'padding'         => 5,     //间距
                'height'          => 30,     //高度
                'width'           => 80,      //宽度
                'foreColor'       => 0xffffff,     //字体颜色
                'offset'          => 4,       //设置字符偏移量 有效果
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data = [];
        parent::setBreadcrumbs([]);
        return parent::renderPage('index.tpl', $data,
            ['with' => ['baiduMap']]);
    }

    /**
     * Login Page
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = null;


        return parent::renderPage('login.tpl', []);
    }


    public function actionDoLogin()
    {
        $request = Yii::$app->request;
        if ($request->getIsPost())
        {
            $captcha = $request->post('captcha');

            $valid = $this->createAction('captcha')->validate($captcha, false);
            if (!$valid) {
                return parent::error(['captcha' => $captcha], -2);
            }

            $username = $request->post('username');
            $password = $request->post('password');

            $user = UserService::login($username, $password);
            if ($user && $user->isLoggedIn())
            {
                Yii::$app->user->login($user);
                Yii::$app->session->open();
                Yii::$app->session->set("user", $user->userInfo());
                return parent::result(['login' => $username]);
            }
            else
            {
                return parent::error(['login' => $username], -1);
            }
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        StationService::getStations();
        return $this->render('about.tpl', []);
    }



    /**
     * ExceptionPage show Errors
     *
     * @return mixed
     */
    public function actionError()
    {
        $this->layout = null;

        $errorHandler = Yii::$app->getErrorHandler();
        $exception = $errorHandler->exception;
        if ($exception instanceof AccessForbiddenException)
        {
            $errorReason = $exception->reason;
            $userInfo = $exception->userInfo;
            if ($userInfo)
            {

            }
        }

        return parent::renderPage('error.tpl', ['errorReason' => $errorReason]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionRequirements()
    {
        // TODO: MySQL connections

        // TODO: Redis connections
        Yii::$app->redis->set('current', time());
        $time = Yii::$app->redis->get('current');

        // TODO:
    }

}
