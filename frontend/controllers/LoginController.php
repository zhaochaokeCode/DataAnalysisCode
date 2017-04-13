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
        //登录检查
        $nameArr = array(
            'baiwen100'=>'Bs0ASasd19',
            'zhaoliang'=>'zl944123',
            'xuchao'=>'xc1024',
            'hanlixiao'=>'hlx123',
            'huzheng'=>'hz739',
        ) ;


        $data = $_POST;
        if(isset($data['name'])&&isset($data['password'])){
            if($data['name']&&$data['password']){
                $userName= $data['name'] ;
                $tmp = array_keys($nameArr) ;
                if(in_array($userName,$tmp)){
                    if($nameArr[$userName]==$data['password']){
                        $session['user_name']=$userName ;
                        echo true ;
                    }
                }else{
                    echo false ;
                }

            }else{
                echo false ;
            }
            return ;
        }
        $this->render('index') ;


    }

}