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
        if(!isset($session['user_name'])){
            $this->render("//login/index") ;
        }else{
//            echo $session['user_name'] ;
        }
    }

}


