<?php

namespace frontend\modules\main\controllers;

use yii\db\Query;
use yii\web\Controller;

/**
 * Default controller for the `main` module
 */
class DefaultController extends Controller
{
    public $layout = 'bootstrap';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "bootstrap";
        $query = new Query();
        $command = $query->from('advert')->orderBy('idadvert desc')->limit(5);
        $result_general = $command->all();
        $count_general = $command->count();

        return $this->render('index',['result_general' => $result_general, 'count_general' => $count_general]);
    }
}
