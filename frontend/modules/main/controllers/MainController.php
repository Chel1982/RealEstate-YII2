<?php

namespace frontend\modules\main\controllers;

use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\SignupForm;
use yii\captcha\CaptchaAction;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class MainController extends Controller
{
    public $layout = 'inner';

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
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if($model->load(\Yii::$app->request->post()) && $model->login()){
            $this->goBack();
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        $this->layout = 'inner';

        $model = new SignupForm();

        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            if($model->load(\Yii::$app->request->post())) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if($model->load(\Yii::$app->request->post()) && $model->signup()){

            \Yii::$app->session->setFlash('success', 'Register Success');
        }

        return $this->render('register', ['model' => $model]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if(\Yii::$app->request->isPost){
            if($model->load(\Yii::$app->request->post()) && $model->validate()){

                $body = " <div>Name: <b> ".$model->name." </b></div>";
                $body .= " <div>Email: <b> ".$model->email." </b></div>";
                $body .= " <div>Body: <b> ".$model->body." </b></div>";

                \Yii::$app->common->sendMail($model->subject, $body);

            }
        }
        return $this->render('contact', ['model' => $model]);
    }

    public function actionLoginData()
    {
        print_r(\Yii::$app->user->identity->username);
    }
}
