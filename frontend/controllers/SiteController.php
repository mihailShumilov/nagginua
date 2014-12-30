<?php
namespace frontend\controllers;

use common\models\Categories;
use common\models\NewsHasCategory;
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'front';
        $notInIds = [ ];

        $sliders = News::find()->where( "created_at BETWEEN DATE_ADD(NOW(), INTERVAL -6 hour) AND NOW() AND thumb  IS NOT NULL" )->orderBy( [ "cnt" => SORT_DESC ] )->limit( 8 )->all();
        foreach ($sliders as $item) {
            $notInIds[] = $item->id;
        }

        $topNews = News::find()->where( "created_at BETWEEN DATE_ADD(NOW(), INTERVAL -6 hour) AND NOW() AND thumb  IS NOT NULL  AND id NOT IN(" . implode( ",",
                $notInIds ) . ")" )->orderBy( [ "cnt" => SORT_DESC ] )->limit( 4 )->all();
        foreach ($topNews as $item) {
            $notInIds[] = $item->id;
        }
        $hotNews = News::find()->where( "thumb  IS NOT NULL AND id NOT IN(" . implode( ",",
                $notInIds ) . ")" )->orderBy( [ "id" => SORT_DESC ] )->limit( 4 )->all();
        foreach ($hotNews as $item) {
            $notInIds[] = $item->id;
        }
        $category = Categories::findOne( [ 'slug' => 'ato' ] );
        $atoNews      = News::find()->joinWith( [ 'newsHasCategories' ] )->where( NewsHasCategory::tableName() . ".category_id = {$category->id} AND " . News::tableName() . ".id NOT IN(" . implode( ",",
                $notInIds ) . ")" )->orderBy( [ "id" => SORT_DESC ] )->limit( 7 )->all();
        foreach ($atoNews as $item) {
            $notInIds[] = $item->id;
        }
        $category = Categories::findOne( [ 'slug' => 'economic' ] );
        $ecoNews      = News::find()->joinWith( [ 'newsHasCategories' ] )->where( NewsHasCategory::tableName() . ".category_id = {$category->id} AND " . News::tableName() . ".id NOT IN(" . implode( ",",
                $notInIds ) . ")" )->orderBy( [ "id" => SORT_DESC ] )->limit( 7 )->all();
        foreach ($ecoNews as $item) {
            $notInIds[] = $item->id;
        }

        $category  = Categories::findOne( [ 'slug' => 'sport' ] );
        $sportNews    = News::find()->joinWith( [ 'newsHasCategories' ] )->where( NewsHasCategory::tableName() . ".category_id = {$category->id} AND " . News::tableName() . ".id NOT IN(" . implode( ",",
                $notInIds ) . ")" )->orderBy( [ "id" => SORT_DESC ] )->limit( 3 )->all();
        foreach ($sportNews as $item) {
            $notInIds[] = $item->id;
        }

        $category     = Categories::findOne( [ 'slug' => 'politics' ] );
        $politicsNews = News::find()->joinWith( [ 'newsHasCategories' ] )->where( NewsHasCategory::tableName() . ".category_id = {$category->id} AND " . News::tableName() . ".id NOT IN(" . implode( ",",
                $notInIds ) . ")" )->orderBy( [ "id" => SORT_DESC ] )->limit( 3 )->all();

        return $this->render( 'index', [
            'topNews' => $topNews,
            'hotNews' => $hotNews,
            'atoNews'      => $atoNews,
            'ecoNews'      => $ecoNews,
            'sportNews'    => $sportNews,
            'politicsNews' => $politicsNews,
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

    public function actionError()
    {
        $this->redirect( "/" );
    }
}
