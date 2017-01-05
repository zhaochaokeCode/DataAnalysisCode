<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/1/3
 * Time: 上午10:54
 */
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Index     controller
 */
class IndexController extends Controller
{
    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');

    }

    /**
     * 获取数据库数据
     */
    public function actionGetdatas(){
        $testData = 'hello world!' ;
        return $this->render('getdatas',array(
            'all_data'=>$testData
            )
        );
    }
}
