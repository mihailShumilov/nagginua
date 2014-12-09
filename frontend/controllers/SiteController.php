<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\News;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'front';
        $topNews = News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( 4 )->all();
        $hotNews = News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( 4 )->offset( 4 )->all();
        $liveNews = News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( 7 )->offset( 8 )->all();
        $worldNews = News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( 7 )->offset( 15 )->all();
        $businessNews = News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( 3 )->offset( 22 )->all();
        $sportNews = News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( 3 )->offset( 25 )->all();
        $sliders = News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( 8 )->offset( 28 )->all();
        return $this->render( 'index', [
            'topNews' => $topNews,
            'hotNews' => $hotNews,
            'liveNews'  => $liveNews,
            'worldNews' => $worldNews,
            'businessNews' => $businessNews,
            'sportNews'    => $sportNews,
            'sliders' => $sliders,
        ] );
    }



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

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCategory( $category )
    {
        die( $category );
    }
}
