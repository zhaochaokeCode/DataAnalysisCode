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

    public function actionIndex(){
//        $tabArr = $this->mssdb->getTabColumn('log_character') ;
        $this->getFileCont() ;


    }
    public function actionGetcol(){

        $tabArr = $this->mssdb->getTabColumn('log_yuanbao') ;
    }
    public function getFileCont(){
        ini_set('memory_limit', '1024M');
        $sinkFile = Yii::$app->params['runFile'];//中间通道数据文件路径
        $logPath = Yii::$app->params['filePath']; //文件保存目录
        $contFile = file_get_contents($sinkFile);

        $fileArr = explode("\n", $contFile);


        foreach($fileArr as $v){
            $allData =array() ;
            $fileName = $logPath. $v;
            $cont = file_get_contents($fileName);
            echo $fileName."<br>" ;
            $datas = explode("\n", $cont);
            unset($cont);


            foreach ($datas as $k => $v) {
                if ($v) {
                    if ($json = json_decode($v)) {
                        $tmpData = $this->objeToArr($json);
                        $name =   $tmpData['f_log_name'] ;

                        if($name == 'log_account'||$name == 'log_character'||$name == 'log_login'){
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
//                        echo $sql ;
                        $tabArr = $this->mssdb->runSql($sql) ;

                    }
                }
            }
            sleep(0.5) ;
            echo "<br><br>" ;
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
                            $tmp = $data['f_account_id']?$data['f_account_id']:0,
                            "'".$data['f_phone_id']."'",
                        );
                break ;
            case 'log_character'://新增角色  11
                //f_uid,f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_account_id,f_character_id,f_character_ip,f_character_type,f_insert_time
                //f_time,f_dept,f_server_address_id,f_account_id,f_character_ip,f_character_type,f_sf_character_id,f_game_id,f_log_name,
                $data = array(
                    $data['f_aaccount_id'],
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
        }
        return $data ;
    }
    public function actionCleardata(){
        $data =  $this->mssdb->clear();

    }
}