<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/2/3
 * Time: 下午3:11
 */
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Login    controller
 */
class CommController extends Controller
{
    public function init()
    {
        $session = Yii::$app->session;
        $url = $_SERVER['REQUEST_URI'];
        if(!isset($session['user_name'])){
            $this->render("//login/index") ;
        }
    }

}


