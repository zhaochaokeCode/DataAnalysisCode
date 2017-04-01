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
    public $tabname ='log_marry' ;

    public function init()
    {
        $this->mssdb = new mss();
    }

    public function actionOnline(){
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
                        $tmpData[] = $this->objeToArr($json);

                        $time =$tmpData['f_time'] ;
                        $data = array(
                            "f_dept"=>$tmpData['f_dept'],
                            "f_server_address_id"=>$tmpData['f_server_address_id'] ,
                            "f_game_id"=>$tmpData['f_game_id'],
                            "f_time"=>"'".date("Y-m-d H:i:s",$time)."'" ,
                            "f_num"=>$tmpData['f_num'] ,
                            "f_vip_num"=>$tmpData['f_VIP_num'],
                        ) ;
                        $str = implode(',',array_values($data)) ;
                        $str2 =  implode(',',array_keys($data)) ;

                        $sql = "insert into log_onlineinfo ($str2) VALUES ($str)" ;
                        $this->mssdb->runSql($sql) ;
                        sleep(0.1);
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

        $tabArr = $this->mssdb->getTabColumn($this->tabname) ;
    }
    public function getFileCont(){
        $p = 0 ;
        ini_set('memory_limit', '1000M');
        $sinkFile = Yii::$app->params['runFile'];//中间通道数据文件路径
        $logPath = Yii::$app->params['filePath']; //文件保存目录
        $contFile = file_get_contents($sinkFile);

        $fileArr = explode("\n", $contFile);

        $tmp2 = array();
//        foreach($fileArr as $v){
            $allData =array() ;
            $fileName = $logPath. $_GET['file'] ;
            $cont = file_get_contents($fileName);
//            echo $fileName."<br>" ;
            $datas = explode("\n", $cont);
            unset($cont);
            $p += count($datas)  ;
            $newArr =array_chunk($datas,12000) ;
            $logArr = array(
                            'log_account', 'log_character', 'log_login', 'log_logout','log_recharge',
                            'log_stage', 'log_dungeon', 'log_jinbi', 'log_consumption', 'log_item', 'log_yuanbao',
                            'log_jinbi', 'log_uplevel', 'log_horse_tame', 'log_equip', 'log_jingjie_up',
//                            'log_killboss',
                        );
            foreach($newArr as $k=>$v) {
                $allData =array() ;
                foreach($v as $v1) {
                    if ($json = json_decode($v1)) {
                        $tmpData = $this->objeToArr($json);
                        $name = $tmpData['f_log_name'];
                        if(in_array($name,$logArr)){
                            $allData[$name][] = $this->createData($name, $tmpData);
                        }
                    }


                }
                foreach($allData as $tabName=>$v){
                    $keyStr = $this->getCol($tabName) ;
                    $valStr = '' ;
                    foreach ($v as $item) {
                        $tmpStr = implode(',', $item);
                        if ($valStr != null) {
                            $valStr .= ",($tmpStr)";
                        } else {
                            $valStr .= "($tmpStr)";
                        }
                    }
                    if ($valStr) {
                        $sql = "INSERT INTO $tabName ($keyStr)  VALUES $valStr ";
                        $tabArr = $this->mssdb->runSql($sql);
                    sleep(0.05) ;
                    }
                }
                unset($allData) ;

            }

            echo $p.'   #' ;





//            foreach ($datas as $k => $v) {
//                if ($v) {
//                    if ($json = json_decode($v)) {
//                        $tmpData[] = $this->objeToArr($json);
//                        continue ;
//                        $name = $tmpData['f_log_name'];
//
//                        $logArr = array(
//                            'log_account', 'log_character', 'log_login', 'log_logout','log_recharge',
//                            'log_stage', 'log_dungeon', 'log_jinbi', 'log_consumption', 'log_item', 'log_yuanbao',
//                            'log_jinbi', 'log_uplevel', 'log_horse_tame', 'log_equip', 'log_jingjie_up',
////                            'log_killboss',
//                        );
//
////                        $logArr = array('log_recharge') ;
//                        //log_horse_tame  log_equip log_skill_up 没数据 log_card_gain有错误
//
//                        //log_card_gain有错误,log_card_train 为空
//
////                      if($name == 'log_account'||$name == 'log_character'||$name == 'log_login'||$name == 'log_logout'
////                        ||$name == 'log_stage'||$name=='log_dungeon'||log_jinbi||log_consumption){
//                        if(in_array($name,$logArr)){
//
//                            if ($name == 'log_consumption') {
//                                if ($tmpData['f_stage_ns'] == 'n') {
//                                    $tmpData['f_stage_ns'] = 0;
//                                }
//                                if ($tmpData['f_stage_ns'] == 's') {
//                                    $tmpData['f_stage_ns'] = 1;
//                                }
//                            }
//                            $allData[$name][] = $this->createData($name, $tmpData);
//                        } else {
//                            continue;
//                        }
//                    }
////                }
//            }

//            $tmpAllKey = array_keys($allData) ;
//            $numLen =50 ;
//            foreach ($tmpAllKey as $tabName) {
//                $tabDataLen = count($allData[$tabName]);
//                $valStr = '' ;
//                $keyStr = $this->getCol($tabName);
//
//                if($tabDataLen>$numLen) {
//
//                    $newArr =array_chunk($allData[$tabName],50) ;
//
//                    foreach($newArr as $k=>$v){
//                        foreach ($v as $item) {
//                            $tmpStr = implode(',', $item);
//                            if ($valStr != null) {
//                                $valStr .= ",($tmpStr)";
//                            } else {
//                                $valStr .= "($tmpStr)";
//                            }
//                        }
//                        if ($valStr) {
//                            $sql = "INSERT INTO $tabName ($keyStr)  VALUES $valStr ";
//                            $tabArr = $this->mssdb->runSql($sql);
//                            sleep(0.2) ;
//                        }
//                    }
//                }else {
//                    foreach ($allData[$tabName] as $v3) {
//                        if($v3) {
//                            $tmpStr = implode(',', $v3);
//                            if ($valStr != null) {
//                                $valStr .= ",($tmpStr)";
//                            } else {
//                                $valStr .= "($tmpStr)";
//                            }
//                        }
//                    }
//                    if ($valStr) {
//                        $sql = "INSERT INTO $tabName ($keyStr)  VALUES $valStr ";
//                        $tabArr = $this->mssdb->runSql($sql);
//                        sleep(0.2) ;
//                    }
//                }
//            }
//            sleep(1) ;
        }
//    }



    public function objeToArr($object)
    {
        $array = array();
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                if ($key == 'f_params') {
                    if ($value) {
                        foreach($value as $k1=>$v1){
                            $tmpArr[$k1] =$v1 ;
                        }
                        $array = $array + $tmpArr;
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
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_rechage_yuanbao,f_orderid,f_discount,f_rechage_money" ;
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
            case 'log_item'://道具日志
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_goods,f_num,f_opt_type,f_note" ;
                break ;
            case 'log_yuanbao'://元宝日志
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_opt_type,f_yuanbao,f_yuanbao_after" ;
                break ;
            case 'log_jinbi': //金币日志
                $keyStr ="f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_opt_type,f_jinbi,f_jinbi_after";
                break ;
            case 'log_uplevel': //等级日志
                $keyStr ="f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip";
                break ;
            case 'log_card_gain'://出错了
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_model_id,f_id,f_card_color,f_yuanbao_num" ;
                break ;
            case 'log_horse_tame': //驭风强化日志
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_horse_model_id,f_horse_modelAfter_id,f_goodsParam,f_code,f_status";
                break;
            case 'log_equip': //装备强化日志
                $keyStr = 'f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_model_id,f_id,f_level_num,f_goods_num';
                break;
            case 'log_jingjie_up': //境界修练日志
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_model_id,f_jingjie_num,f_zhenqi_num,f_jinbi_num";
                break ;
            case 'log_killboss': //野外boss
                $keyStr = "f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_boss_id" ;
                break ;
            case 'log_marry':
                $keyStr ="f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_m_yunying_id,f_w_yunying_id,f_m_character_id,f_w_character_id,f_m_character_grade,f_w_character_grade,f_m_character_ip,f_w_character_ip,f_lovetoken_id";
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
                $data2 = array(
                            $data['f_aaccount_id'],
                            $data['f_dept'],
                            $data['f_server_address_id'],
                            $data['f_game_id'],
                            "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                            $data['f_sid'],
                            "'".$data['f_yunying_id']."'",
                            $tmp = $data['f_aaccount_id']?$data['f_aaccount_id']:0,
                            "'".$data['f_phone_id']."'",
                        );
                break ;
            case 'log_character'://新增角色  11

                $data2 = array(
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
                $data2 = array(
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
                $data2 = array(
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
                $data2 = array(
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
                    $tmp = $data['f_recharge_yuanbao']? $data['f_recharge_yuanbao']:0,
                    $t.$data['f_orderid'].$t,
                    $data['f_discount'],
                    $data['f_rechage_money'],
                );
                break ;
               // $keyStr = "f_character_grade,f_character_ip,f_stage_id,f_stage_ns,f_code";
                case 'log_stage'://12
                    $data2 = array(
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
                $data2 = array(
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
                $data2 = array(
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


            case 'log_item'://道具日志
            //    $keyStr = "f_character_grade,f_character_ip,f_goods,f_num,f_opt_type,f_note"
                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_goods'],
                    $data['f_num'],
                    $data['f_opt_type'],
                    $t.$data['f_note'].$t
                );
                break ;


            case 'log_yuanbao'://元宝日志
            //    $keyStr = "f_opt_type,f_yuanbao,f_yuanbao_after"
            $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_opt_type'],
                    $data['f_yuanbao'],
                    $data['f_yuanbao_after'],
                );
                break ;

            case 'log_jinbi'://金币日志
                //_opt_type,f_jinbi,f_jinbi_after
                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_opt_type'],
                    $data['f_jinbi'],
                    $data['f_jinbi_after'],
                );
                break ;
            case 'log_uplevel'://等级日志
            //f_yunying_id,f_character_id,f_character_grade,f_character_ip";
                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,
                );
                break ;
            case 'log_card_gain'://灵偶抽卡日志
            // f_model_id,f_id,f_card_color,f_yuanbao_num" ;
                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_model_id'],
                    $data['f_id'],
                    $data['f_card_color'],
                    $data['f_yuanbao_num'],

                );
                break ;
            //f_horse_model_id,f_horse_modelAfter_id,f_goodsParam,f_code,,";
            case 'log_horse_tame'://玉峰强化日志
                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_horse_model_id'],
                    $data['f_horse_modelAfter_id'],
                    $t.$data['f_goodsParam'].$t,
                    $data['f_code'],
                    $data['f_status'],

                );
                break ;

            case 'log_equip': //装备强化日志

                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_model_id'],
                    $t.$data['f_id'].$t,
                    $data['f_level_num'],
                    $t.$data['f_goods_num'].$t,
                );
                break ;

            case 'log_jingjie_up': //装备强化日志
                //   f_model_id,f_jingjie_num,f_zhenqi_num,f_jinbi_num";
                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,

                    $data['f_model_id'],
                    $data['f_jingjie_num'],
                    $data['f_zhenqi_num'],
                    $data['f_jinbi_num'],
                );
                break ;

            //       de,f_character_ip,f_boss_id" ;
            case 'log_killboss': //装备强化日志

                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],
                    "'".$data['f_yunying_id']."'",
                    $data['f_character_id'],
                    $data['f_character_grade'],
                    $t.$data['f_character_ip'].$t,
                    $data['f_boss_id'],
                );
                break ;
            case 'log_marry':
                $keyStr ="f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_m_yunying_id,f_w_yunying_id,f_m_character_id,f_w_character_id,f_m_character_grade,f_w_character_grade,f_m_character_ip,f_w_character_ip,f_lovetoken_id";
                break ;
        }
        return $data2 ;
    }
    public function actionCleardata(){

//        $data =  $this->mssdb->clear();

    }
}