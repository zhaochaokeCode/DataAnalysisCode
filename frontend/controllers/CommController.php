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
    public $where ;
    public function init()
    {
        $session = Yii::$app->session;
        if(!isset($session['user_name'])){
            $this->render("//login/index") ;
        }else{
//            echo $session['user_name'] ;
        }
        $where = 'where 1';

        if ($_GET['starttime']) {
            $where .= ' and f_time>=' . strtotime($_GET['starttime']);
        }

        if ($_GET['endtime']) {
            $where .= ' and f_time<=' . strtotime($_GET['endtime']);
        }
        $this->where = $where ;

    }
    public function getWhere(){
        return $this->where ;
    }
}


