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
        if(!isset($session['user_name'])&&!isset($_GET['create_data'])){
            $this->render("//login/index") ;
        }
//        else{
//            echo $session['user_name'] ;
//        }
        $where = 'where 1';
        if(!$_GET['starttime']){
            $now = time() ;
            $_GET['starttime'] = date("Y-m-d 00:00:00",$now - 86400*30) ;
            $_GET['endtime']   = date("Y-m-d 00:00:00",$now );
        }
        if ($_GET['starttime']) {
            $where .= ' and f_time>=' . strtotime($_GET['starttime']);
        }

        if ($_GET['endtime']) {
            $where .= ' and f_time<=' . strtotime($_GET['endtime']);
        }
        $this->where = $where ;
        if($_GET['snid']){


        }
        if($_POST){
            if($_POST['sign']){
                $this->checkSign($_POST);
            }
        }

    }

    /**
     * @return 获取查询条件
     */
    public function getWhere(){
        return $this->where ;
    }
    public function getStrart(){
        return strtotime(date("Y-m-d",strtotime('-1 days')));
    }

    /**
     * @return string 获取需要调用的方法名的字符串
     */
    public function getFuntionName(){
        //通用方法名数组
        $actionArr = array('character','recharge','jinbi','card_train','skill_up',
                            'jingjie_up','killboss','yuanbao') ;
        $suffix    = 'CreateData' ;//方法名后缀

        if(in_array($_GET['action'],$actionArr)){
            return  'comm'.$suffix ;
        }else{
            if($_GET['action']=='customer_churn') return 'customerChurn'.$suffix ;
            //特殊方法名数组
            return  $_GET['action'].$suffix ;
        }
    }






//
//     * 获取完整数据
//     * 完整数据由两部分组成,组合后生成完整的数据结构(json串通信协议) 提供给php和js
//     * 整个展示界面由图和表格组成,一般情况下每张图的数据和其中的一个表格是关联在一起的
//     * js负责生成和展示视图,php负责生成和展示表格,如果没有视图,php全部生成相关的代码
//     * 所有数据一次生成好之后,js负责图表的显示和隐藏,还有ajax的表格刷新
//     * 第一部分是配置相关数据
//     *          它包括报表的名称,报表title显示的字段 ,距离区间,各种配置参数等等.由配置文件读取
//     * 第二部分为有游戏数据仓库生成的数据
//     *
    public function createData($allGame,$key=false)
    {
        //配置相关参数

        $conDatas = Yii::$app->params['tabConfig'];
        $key = $key?$key:$_GET['action'];
        $configDatas = $conDatas['gamePlayer'][$key];

        /**
         * 调用第一步生成游戏数据
         */
        //游戏相关数据 三个数据 游戏数据,当前第几页,总共多少页

        //没有数据 返回
        if (!$allGame[0]) return $allGame;

        /**
         * 第二步为数据添加配置数据,并声称js可以使用的数据结构
         */
        //增加表格数据和tag标签名称
        foreach ($configDatas['tab_all'] as $k => $v) {
            array_unshift($allGame[$k]['tab'], $v['thred']);
            $allGame[$k]['tab'] = json_encode($allGame[$k]['tab']); //tab的时间标示
            //这个还得去大数组中去取
            $allGame[$k]['tag'] = $configDatas['tag'][$k];

            //为每个数据视图线提供数据名称
            $nameArr = $configDatas['tag'][$k]['name'] ;

            //---关键性数据----为每个视图生成seri数据
            foreach($nameArr as $key1=>$val1){
                $tmArr[] = array(
                    'name'=>$val1,
                    'data'=>$allGame[$k]['series'][$key1]
                );
            }

            $allGame[$k]['series'] = json_encode($tmArr) ;


        }
        return $allGame;

    }
    public function commLogClo($data)
    {
        $array=array('f_dept',//平台标识
                    'f_server_address_id',//物理服务器编号
                    'f_sid',            //服务器ID
                    'f_game_id',        //游戏ID
                    'f_character_id') ; //角色ID

        foreach($data as $v){
            $keyArr = array_keys($v) ;
            foreach($keyArr as $key){
                if(in_array($key,$array)){
                    $retArr[] = $v[$key] ;
                }
            }

        }

    }
    /**
     * 保留两位小数的算法
     */
    public function getZeroNum($num){
        if($num!=0){
            return substr($num*100,-2,10).".".substr($num*100,-1,2) ;
        }else{
            return "0.00" ;
        }

    }


}


