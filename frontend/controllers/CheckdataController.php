<?php

namespace frontend\controllers;


use Yii ;
use yii\web\Controller;


class CheckdataController extends Controller
{
    public function actionIndex()
    {
        $data = '/data/flume_logs/skill_log/1486277205420-240' ;
        $tmp = file_get_contents($data) ;

        $test = " " ;



    }

}
