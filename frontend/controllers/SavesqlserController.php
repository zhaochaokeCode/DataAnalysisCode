<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/3/17
 * Time: 下午7:01
 */
namespace frontend\controllers;
require_once '../lib/mss.php' ;
use yii ;
use mss ;
use yii\web\Controller;
header("Content-type: text/html; charset=utf-8");
class SavesqlserController extends Controller
{
    public $layout = false;

    public $cusKey = false;
    public $valArr;

    public $days = 7;

    public $mssdb = '';

    public function init()
    {
        $this->mssdb = new mss();
    }

    public function actionOnline(){

        $str = '{"f_time":1490784960,"f_params":{"f_dept":"1","f_server_address_id":"1","f_num":"5","f_time":"2017-03-29 18:56:00","f_VIP_num":"0","f_game_id":"1"},"f_game_id":1,"f_log_name":"log_onlineinfo"}' ;
        $tmp = $this->objeToArr(json_decode($str)) ;





        var_dump($tmp) ; die;

        ini_set('memory_limit', '1024M');
        $sinkFile = Yii::$app->params['online'];//中间通道数据文件路径
        $logPath = Yii::$app->params['onlinePath']; //文件保存目录
        $contFile = file_get_contents($sinkFile);

        $fileArr = explode("\n", $contFile);

        $tmp2 = array();
        foreach($fileArr as $v) {
            $allData = array();
            $fileName = $logPath . $v;
            $cont = file_get_contents($fileName);
            $datas = explode("\n", $cont);
            unset($cont);

            foreach ($datas as $k => $v) {
                if ($v) {
                    if ($json = json_decode($v)) {
                        $tmpData = $this->objeToArr($json);
                        $time =$tmpData['f_time'] ;
                        $data = array(
                            "f_dept"=>$tmpData['f_dept'],
                            "f_server_address_id"=>$tmpData['f_server_address_id'] ,
                            "f_game_id"=>$tmpData['f_game_id'],
                            "f_time"=>date("Y-m-d H:i:s,$time") ,
                            "f_num"=>$tmpData['f_num'] ,
                            "f_vip_num"=>$tmpData['f_VIP_num'],
                        ) ;
                        $str = explode(',',array_values($data)) ;
                        $sql = "insert into log_onlineinfo VALUES ($str )" ;
                        echo $sql ; die;

                    }
                }
            }

        }

    }


    public function actionIndex(){
//        $this->mssdb->getUserInfo() ; die;
//        $tabArr = $this->mssdb->getTabColumn('log_character') ;
        $this->getFileCont() ;

//

    }
    public function actionGetcol(){

        $tabArr = $this->mssdb->getTabColumn('log_consumption') ;
    }
    public function getFileCont(){
        ini_set('memory_limit', '1024M');
        $sinkFile = Yii::$app->params['runFile'];//中间通道数据文件路径
        $logPath = Yii::$app->params['filePath']; //文件保存目录
        $contFile = file_get_contents($sinkFile);

        $fileArr = explode("\n", $contFile);

        $tmp2 = array();
        foreach($fileArr as $v){
            $allData =array() ;
            $fileName = $logPath. $v;
            $cont = file_get_contents($fileName);
//            echo $fileName."<br>" ;
            $datas = explode("\n", $cont);
            unset($cont);

            foreach ($datas as $k => $v) {
                if ($v) {
                    if ($json = json_decode($v)) {
                        $tmpData = $this->objeToArr($json);
                        $name =   $tmpData['f_log_name'] ;

//                      if($name == 'log_account'||$name == 'log_character'||$name == 'log_login'||$name == 'log_logout'
//                        ||$name == 'log_stage'||$name=='log_dungeon'){
                        if($name == 'log_consumption'){
                            if($tmpData['f_stage_ns']=='n'){
                                $tmpData['f_stage_ns']=0;
                            }
                            if($tmpData['f_stage_ns']=='s'){
                                $tmpData['f_stage_ns']=1;
                            }
                            $allData[$name][] = $this->createData($name,$tmpData ) ;
                        }else{
                            continue ;
                        }
                    }
                }
            }

            foreach($allData as $k=>$v) {
                if (count($v[0])>1) {
                    $valStr = '';
                    $tabName = $k;

                    foreach ($v as $v3) {
                        $tmpStr = implode(',', $v3);
                        if ($valStr!=null) {
                            $valStr .= ",($tmpStr)";
                        } else {
                            $valStr .= "($tmpStr)";
                        }
                    }

                    $keyStr = $this->getCol($k) ;
                    if($valStr) {
                        $sql = "INSERT INTO $tabName ($keyStr)  VALUES $valStr ";
                        echo $sql ;
                        $tabArr = $this->mssdb->runSql($sql) ;

                    }
                }
            }
            sleep(0.5) ;
        }
    }



    public function objeToArr($object)
    {
        $array = array();
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                if ($key == 'f_params') {
                    if ($value) {
                        $array = $array + $this->objeToArr($value);
                    }
                } else {
                    $array[$key] = $value;
                }
            }
        } else {
            $array = $object;
        }

        return $array;
    }
    public function getCol($tab){
        switch ($tab) {
            case 'log_account':  //创建用户
                $keyStr = "f_uid,f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_account_id,f_phone_id";
                break ;
            case 'log_character'://创建角色
                $keyStr = "f_uid,f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_account_id,f_character_id,f_character_ip,f_character_type" ;
                break ;
            case 'log_login':    //登录
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_vip_grade,f_fighting" ;
                break ;
            case 'log_logout':   //登出
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_nstage_id,f_sstage_id,f_jinbi,f_yuanbao,f_zhenqi,f_online_time" ;
                break ;
            case 'log_recharge': //充值
                $keyStr = "f_uid,f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_rechage_yuanbao,f_orderid,f_discount" ;
                break ;
            case 'log_stage':	//剧情关卡开始及完成日志
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_stage_id,f_stage_ns,f_code";
                break ;
            case 'log_dungeon': //普通副本日志
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_dungeon_id,f_nandu_id,f_success";
                break ;
            case 'log_consumption'://商城消费分析日志
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_goods_model_id,f_goods_price,f_goods_num,f_consume_yuanbao_num,f_overplus_yuanbao_num,f_yuanbao_channel";
                break ;
        }
        return $keyStr ;
    }
    public function createData($name,$data)
    {
        $t = "'" ;
//        $log_account = array('f_uid', 'f_dept', 'f_server_address_id', 'f_game_id', 'f_time', 'f_sid', 'f_yunying_id', 'f_account_id', 'f_phone_id', 'f_insert_time');
        switch ($name) {
            case 'log_account'://新开账户
               // array(9) { ["f_time"]=> int(1489812269) ["f_dept"]=> string(1) "0" ["f_server_address_id"]=> string(1) "0" ["f_aaccount_id"]=> string(6) "242341" ["f_phone_id"]=> string(32) "72226046ce6db0415881d3c61e7cdfb2" ["f_sid"]=> string(1) "0" ["f_yunying_id"]=> string(24) "58ccbb1d36a5f33d044480d6" ["f_game_id"]=> int(1) ["f_log_name"]=> string(11) "log_account" }
                $data = array(
                            $data['f_aaccount_id'],
                            $data['f_dept'],
                            $data['f_server_address_id'],
                            $data['f_game_id'],
                            "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                            $data['f_sid'],
                            "'".$data['f_yunying_id']."'",
                            $tmp = $data['f_aaccount_id']?$data['f_account_id']:0,
                            "'".$data['f_phone_id']."'",
                        );
                break ;
            case 'log_character'://新增角色  11
                //f_uid,f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_account_id,f_character_id,f_character_ip,f_character_type,f_insert_time
                //f_time,f_dept,f_server_address_id,f_account_id,f_character_ip,f_character_type,f_sf_character_id,f_game_id,f_log_name,
                $data = array(
                    $data['f_account_id'],
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $tmp = $data['f_account_id']?$data['f_account_id']:0,//8

                    $data['f_character_id'],
                    $t.$data['f_character_ip'].$t,
                    $data['f_character_type']
                );
                break ;
            case 'log_login'://12
                //f_uid,f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_vip_grade,f_fightin
                $data = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $tmp = $data['f_character_id'],//8


                    ///f_character_grade,f_character_ip,f_vip_grade,f_fighting
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,
                    $data['f_vip_grade'],
                    $data['f_fighting']
                );
                break ;
            case 'log_logout'://12
                //f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_nstage_id,f_sstage_id,f_jinbi,f_yuanbao,f_zhenqi,f_online_time,f_insert_time,17
                $data = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $tmp = $data['f_character_id'],//8


                    //f_nstage_id,f_sstage_id,f_jinbi,f_yuanbao,f_zhenqi,f_online_time
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,
                    $data['f_nstage_id'],
                    $data['f_sstage_id'],
                    $data['f_jinbi'],
                    $data['f_yuanbao'],
                    $data['f_zhenqi'],
                    $data['f_online_time'],

                );
                break ;
            case 'log_recharge'://12
                //f_uid,f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_rechage_yuanbao,f_orderid,f_discount
                $data = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $tmp = $data['f_character_id'],//8


                    //,f_character_ip,f_rechage_yuanbao,f_orderid,f_discount
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,
                    $data['f_rechage_yuanbao'],
                    $t.$data['f_orderid'].$t,
                    $data['f_discount']
                );
                break ;
               // $keyStr = "f_character_grade,f_character_ip,f_stage_id,f_stage_ns,f_code";
                case 'log_stage'://12
                    $data = array(
                        $data['f_dept'],
                        $data['f_server_address_id'],
                        $data['f_game_id'],
                        "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                        $data['f_sid'],
                        "'".$data['f_yunying_id']."'",
                        $tmp = $data['f_character_id'],//8


                        //,f_character_ip,f_rechage_yuanbao,f_orderid,f_discount
                        $data['f_character_grade'],
                        $t.$data['f_character_ip'].$t,
                        $data['f_stage_id'],
                        $data['f_stage_ns'],
                        $data['f_code']
                    );
                break ;
            //f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_dungeon_id,f_nandu_id,f_success
            case 'log_dungeon'://12
                //  "f_character_grade,f_character_ip,f_dungeon_id,f_nandu_id,f_success";
                $data = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $tmp = $data['f_character_id'],//8


                    //,f_character_ip,f_rechage_yuanbao,f_orderid,f_discount
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,
                    $data['f_dungeon_id'],
                    $data['f_nandu_id'],
                    $data['f_success']
                );
                break ;
            case 'log_consumption':
                //"f_goods_model_id,f_goods_price,f_goods_num,f_consume_yuanbao_num,f_overplus_yuanbao_num,f_yuanbao_channel";
                $data = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $tmp = $data['f_character_id'],//8


                    //,f_character_ip,f_rechage_yuanbao,f_orderid,f_discount
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_goods_model_id'],
                    $data['f_goods_price'],
                    $data['f_goods_num'],
                    $data['f_consume_yuanbao_num'],
                    $data['f_overplus_yuanbao_num'],
                    $data['f_yuanbao_channel']
                );
                break ;

        }
        return $data ;
    }
    public function actionCleardata(){

//        $data =  $this->mssdb->clear();

    }
}