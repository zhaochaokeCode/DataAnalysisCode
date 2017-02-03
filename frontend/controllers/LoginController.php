<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/2/3
 * Time: 上午10:30
 */
namespace frontend\controllers;

//use frontend\controllers\CommController ;
use Yii ;
use  yii\web\Session;
use yii\web\Controller;
/**
 * Login    controller
 */
class LoginController extends Controller{

    public function actionIndex(){

        $session = Yii::$app->session;
//        if(isset( $session['user_name'])){
//            echo $session['user_name'] ;
//            $this->redirect("http://172.16.67.180");  die;
//        }
        //登录检查
        if(isset($_POST['name'])&&isset($_POST['password'])){
            if($_POST['name']&&$_POST['password']){
                $session['user_name']= $_POST['name'] ;
                echo true ;
            }else{
                echo false ;
            }
            return ;
        }
        $this->render('index') ;


    }

}