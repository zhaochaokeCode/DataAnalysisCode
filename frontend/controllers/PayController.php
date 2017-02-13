<?php

namespace frontend\controllers;


use Yii ;
use yii\web\Controller;

class PayController extends Controller
{
    public function actionIndex()
    {

    }
    public function actionCreateorder(){
        var_dump($_POST) ;
        if($_POST){
            echo file_put_contents('/tmp/data.txt',json_encode($_POST)."\n",FILE_APPEND) ;
        }
    }

}
