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
     * 展示相关数据
     */
    public function actionGetdatas(){
        $testData = $this->createData() ;
        return $this->render('getdatas',array(
            'all_data'=>$testData
            )
        );
    }

    /**
     * 获取完整数据
     * 完整数据由两部分组成,组合后生成完整的数据结构(json串通信协议) 提供给php和js
     * 整个展示界面由图和表格组成,一般情况下每张图的数据和其中的一个表格是关联在一起的
     * js负责生成和展示视图,php负责生成和展示表格,如果没有视图,php全部生成相关的代码
     * 所有数据一次生成好之后,js负责图表的显示和隐藏
     * 第一部分是配置相关数据
     *          它包括报表的名称,报表title显示的字段 ,距离区间,各种配置参数等等.由配置文件读取
     * 第二部分为有游戏数据仓库生成的数据
     *
     */
    private function createData(){
        //配置相关数据
        $configDatas  = $this->getTabCon() ;




    }

    /**
     * 从配置文件中获取配置相关的数据
     */

    private function getTabCon(){
//      echo   Yii::$app->params['adminEmail']; die ;

    }




    /**
     * @param 游戏数据仓库相关数据
     */
    private function getData($action){




    }




}
