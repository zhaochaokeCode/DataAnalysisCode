<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/1/3
 * Time: 上午11:09
 */
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller{
    public  function  actionIndex()
    {
        echo  'Hello World!' ;die;
    }
}