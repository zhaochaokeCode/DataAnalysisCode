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

        $testData = json_encode($this->createData()) ;
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
        //配置相关参数
        $configDatas  = $this->getTabCon() ;


        //游戏相关数据
        $gameDatas    = $this->getData() ;
        $gameDatasKey = 0 ;

        //把游戏相关数据加到原来的配置数据结构中 ,key为新的series
        //游戏数据是一条一条插进去的 所以每次$gameDatasKey 需要加一,取下一条 这个是难点
        foreach($configDatas as $k=>$v){
            foreach($v['dataName'] as $key1=>$val1){
                $configDatas[$k]['series'][]=
                            array('name' => $val1,
                            'data' => $gameDatas[$gameDatasKey] ) ;
                $gameDatasKey++ ;
            }
        }

        return $configDatas ;

    }

    /**
     * 从配置文件中获取配置相关的数据
     * 根据get参数判断
     */

    private function getTabCon(){
        $conDatas = Yii::$app->params['tabConfig'] ;

        return $conDatas['gamePlayer']['install'] ;


    }




    /**
     * @param 游戏数据仓库相关数据
     * 根据get参数判断
     */
    private function getData(){
//        $data1 = array(explode(',', '100.0,6.9,9.5,14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6' ));
        $data1 = explode(',', '100.0,6.9,9.5,14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6' );
//        $data1[] =  $data1[0] ;
        $data2 = explode(',','-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5') ;
        foreach($data1 as &$v){
            $v =(double)$v ;
        }
        foreach($data2 as &$v){
            $v =(double)$v ;
        }
        return array($data1,$data2,$data2) ;

    }




}
