<?php

namespace app\controllers;

use app\models\AddFile;
use app\models\ViewForm;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\IndexForm;
use yii\data\Pagination;
use app\models\UploadForm;
use yii\web\UploadedFile;



class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * {@inheritdoc}
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new IndexForm();
        $mod= '';
        if ($model->load(Yii::$app->request->post())) {
            $mod = $model->auto;
        }

        return $this->render('index',['model'=>$model, 'mod'=>$mod]);
    }

    public function actionNew()
    {

        $model = new UploadForm();
        $add = new AddFile();

        $query  = ViewForm::find();
//        $list = Json::encode($query);
//        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $query->count()]);
        $list = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('new', [
            'lists'=> $list,
            'pages' => $pages,
            'model' => $model,
            'add'=> $add
            ]);
    }

    public function actionUpload()
    {

        $model = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->dataFile = UploadedFile::getInstance($model, 'dataFile');
            if ($model->upload()) {
                $int = $model->replace();
                if ($int) {
                    Yii::$app->session->setFlash('success', $int);

                } else Yii::$app->session->setFlash('error', 'Ошибка');

            }
            else Yii::$app->session->setFlash('error', 'Ошибка');
        }
        return $this->redirect(['new']);
    }

    public function actionAddData(){

        $add = new AddFile();

        if ($add->load(Yii::$app->request->post())) {
            $add->newFile = UploadedFile::getInstance($add, 'newFile');
            $add->upload();
            $add = $add->add();
            if ($add) {
                Yii::$app->session->setFlash('success', $add);
            }
            else {
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
            return $this->redirect(['new']);
        }
    }


}
