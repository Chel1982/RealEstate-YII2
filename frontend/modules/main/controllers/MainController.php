<?php

namespace frontend\modules\main\controllers;

use common\models\Advert;
use common\models\LoginForm;
use frontend\models\ContactForm;
use frontend\models\SignupForm;
use yii\base\DynamicModel;
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

    public function actionViewAdvert($id)
    {
        $model = Advert::findOne($id);

        $data = ['name', 'email', 'text'];
        $model_feedback = new DynamicModel($data);
        $model_feedback->addRule('name','required');
        $model_feedback->addRule('email','required');
        $model_feedback->addRule('text','required');
        $model_feedback->addRule('email','email');


        if(\Yii::$app->request->isPost) {
            if ($model_feedback->load(\Yii::$app->request->post()) && $model_feedback->validate()){

                \Yii::$app->common->sendMail('Subject Advert',$model_feedback->text);
            }

        }

        $user = $model->user;
        $images = \frontend\components\Common::getImageAdvert($model,false);

        $current_user = ['email' => '', 'username' => ''];

        if(!\Yii::$app->user->isGuest){

            $current_user['email'] = \Yii::$app->user->identity->email;
            $current_user['username'] = \Yii::$app->user->identity->username;

        }

        return $this->render('view_advert',[
            'model' => $model,
            'model_feedback' => $model_feedback,
            'user' => $user,
            'images' =>$images,
            'current_user' => $current_user
        ]);

    }

}
