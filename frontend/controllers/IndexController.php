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
        $action = isset($_GET['action'])?$_GET['action']:'character' ;
        return $this->render('index',
                        array('action'=>$action));
    }

    /**
     * 展示相关数据
     */
    public function actionGetdatas()
    {
        if($_GET['page']){//查询
            $this->getData() ;
        }
        $allData = $this->createData();
        return $this->render('getdatas', array('all_data'=>$allData));
    }

    /**
     * 测试分页
     */
    public function actionPages()
    {
        return $this->render('pageshow');
    }


    /**
     * 获取完整数据
     * 完整数据由两部分组成,组合后生成完整的数据结构(json串通信协议) 提供给php和js
     * 整个展示界面由图和表格组成,一般情况下每张图的数据和其中的一个表格是关联在一起的
     * js负责生成和展示视图,php负责生成和展示表格,如果没有视图,php全部生成相关的代码
     * 所有数据一次生成好之后,js负责图表的显示和隐藏,还有ajax的表格刷新
     * 第一部分是配置相关数据
     *          它包括报表的名称,报表title显示的字段 ,距离区间,各种配置参数等等.由配置文件读取
     * 第二部分为有游戏数据仓库生成的数据
     *
     */
    private function createData()
    {
        //配置相关参数

        $conDatas = Yii::$app->params['tabConfig'];
        $key = $_GET['action'];
        $configDatas = $conDatas['gamePlayer'][$key];

        //游戏相关数据 三个数据 游戏数据,当前第几页,总共多少页
        $allGame = $this->getData();

        //增加表格数据和tag标签名称
        foreach ($configDatas['tab_all'] as $k=>$v) {
            array_unshift($allGame[$k]['tab'], $v['thred']);
            $allGame[$k]['tab'] = json_encode( $allGame[$k]['tab']) ;
            //这个还得去大数组中去取
            $allGame[$k]['tag'] =$configDatas['tag'][$k] ;
            $allGame[$k]['series'] = json_encode(array(
                                        array(
                                            'name'=>$configDatas['tag'][$k]['name'] ,
                                            'data'=>$allGame[$k]['series']
                                        )
                )
                                 ) ;

        }
        return $allGame ;

    }




    /**
     * @param 游戏数据仓库相关数据
     * 根据get参数判断
     *
     * 这个方法需要动态生成数据 ,不能通用了
     */
    private function getData()
    {

        $tabName =  "bi_log_".$_GET['action'] ;

        $connection = Yii::$app->db ;
        $command = $connection->createCommand("SELECT * FROM  $tabName order BY f_time asc");
        $allDatas = $command->queryAll();
//        var_dump($allDatas) ;
//        if($_GET['action']=='character')
        $numArr = array() ;
        $dateArr= array() ;
        foreach($allDatas as $k=>$v){
            foreach($v as $k1=>$v1)
            if($k1=='f_time'){
                $v1 = date("Y-m-d",$v1) ;
                if(in_array($v1,$dateArr)){
                    $numArr[$v1]++;
                }else {
                    $numArr[$v1] = 0;
                    $dateArr[] = $v1;
                }
            }

        }
        $count = count($numArr) ;
        $page = $_GET['page']?$_GET['page']:1;

        foreach($numArr as $k=>$v){
            $tabArr[] = array($k,$v) ;
        }


        //一个表格配置一个视图
        return  $allTableData  = array( array(
                                'count' => $count,
                                'page' => $page,
                                'categories'=>json_encode($dateArr),
                                'series'=>array_values($numArr), //这个还需要重新分配数组,如果是多维度
                                'tab'=>$tabArr
                                ));


    }


}
