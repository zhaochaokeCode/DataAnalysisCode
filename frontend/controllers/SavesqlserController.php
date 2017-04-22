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
    public $tabname ='log_card_train' ;

    public function init()
    {
        $this->mssdb = new mss();
    }

    public function actionOnline(){
        ini_set('memory_limit', '1024M');
        $sinkFile = Yii::$app->params['online'];//中间通道数据文件路径
        $logPath = Yii::$app->params['onlinePath']; //文件保存目录
        $contFile = file_get_contents($sinkFile);

        $fileName = $logPath.$_GET['file'];
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
                            "f_time"=>"'".date("Y-m-d H:i:s",$tmpData['f_time'])."'" ,
                            "f_num"=>$tmpData['f_num'] ,
                            "f_vip_num"=>$tmpData['f_VIP_num']?$tmpData['f_VIP_num']:0,
                        ) ;
                        $str = implode(',',array_values($data)) ;
                        $str2 =  implode(',',array_keys($data)) ;

                        $sql = "insert into log_onlineinfo ($str2) VALUES ($str)" ;
                        $this->mssdb->runSqldata($sql) ;

                    }
                }

        }

    }
    public function actionDelesomeorder()
    {
        $sql = "select f_orderid,f_dept,f_sid from log_recharge group by f_orderid ,
                f_dept,f_sid having count(1) >= 2" ;
        $data = $this->mssdb->runSql($sql) ;
        if($data){
            foreach($data as $newVal){

                $oderid = $newVal['f_orderid'] ;
                $deptid = $newVal['f_dept'];
                $snid   = $newVal['f_sid'];


                $sql = "select max(id)a from log_recharge where
                      f_orderid='$oderid' and f_dept=$deptid AND
                      f_sid = $snid ";
                $data2 = $this->mssdb->runSql($sql) ;
                $id = $data2[0]['a'] ;

                $sql = "DELETE from log_recharge  where    f_orderid='$oderid' and f_dept=$deptid AND
                      f_sid = $snid  and id!=$id" ;
                $data3 = $this->mssdb->runSqldata($sql) ;
            }
        }
    }

    public function actionIndex(){


//        $this->mssdb->getUserInfo() ; die;
//        $tabArr = $this->mssdb->getTabColumn('log_character') ;
        $this->getFileCont() ;

//

    }

    public  function  actionCheckdata(){
        $num =  $_GET['num'] ;
        $path = $_GET['file'] ;
        ini_set('memory_limit', '1000M');
        $dir = "/data/flume_logs/$path/" ;
        $handle = opendir($dir);
        if ( $handle )
        {
            while ( ( $file = readdir ( $handle ) ) !== false )
            {
                if ( $file != '.' && $file != '..')
                {
                    $tmpFile = explode("-",$file) ;
                    $key = $tmpFile[0] ;
                    if($tmpFile[1]>$num)
                    $fileArr[$key][] = $tmpFile[1] ;
                }
            }
            closedir($handle);
        }

        $tmpKey = array_keys($fileArr) ;
        $key    = $tmpKey[0] ;
        $valArr = array_values($fileArr[$key]) ;

        sort($valArr) ;

        foreach($valArr as $val){
            $str .= $key.'-'.$val."\n" ;
        }
        if(isset($_GET['bu_fei1'])){
            file_put_contents('/data/file_name_bei1.txt',$str) ;
            die;
        }
        if(isset($_GET['bu_fei2'])){
            file_put_contents('/data/file_name_bei2.txt',$str) ;
            die;
        }

        file_put_contents('/data/file_name.txt',$str) ;
    }

    public function actionBudata(){


        $path = $_GET['file'] ;
        $dir = "/data/flume_logs/$path/" ;
        ini_set('memory_limit', '1000M');

         $cont = file_get_contents($dir.$_GET['name']);
         $datas = explode("\n", $cont);

         unset($cont);
         $nums = count($datas);
         $lenNum = 3000;

         if ($nums > $lenNum) {
             $length = ceil($nums / $lenNum);
             for ($i = 0; $i < $length; $i++) {
                 for ($k = 0; $k < $lenNum; $k++) {
                     $start = $k + $i * $lenNum;
                     $newArr[$i][] = $datas[$start];
                 }
             }
         } else {
             $newArr = array($datas);
         }
         unset($datas);

         $logArr = array(
             'log_account', 'log_character', 'log_login', 'log_logout', 'log_recharge',
             'log_yuanbao', 'log_item', 'log_uplevel', 'log_consumption',
             'log_stage', 'log_card_gain', 'log_card_train', 'log_horse_tame', 'log_equip',
             'log_skill_up', 'log_jingjie_up', 'log_killboss', 'log_dungeon', 'log_marry',
         );
         foreach ($newArr as $k => $v) {
             $allData = array();
             foreach ($v as $k1 => $v1) {
                 if ($json = json_decode($v1)) {
                     $tmpData = $this->objeToArr($json);
                     $name = $tmpData['f_log_name'];//
                     if (in_array($name, $logArr)) {
                         if($tmpData['f_time']>=1492531200)
                             $allData[$name][] = $this->createData($name, $tmpData);
                     }
                 }
             }
             foreach ($allData as $tabName => $v2) {
                 $keyStr = $this->getCol($tabName);
                 $valStr = '';
                 foreach ($v2 as $item) {
                     $tmpStr = implode(',', $item);
                     if ($valStr != null) {
                         $valStr .= ",($tmpStr)";
                     } else {
                         $valStr .= "($tmpStr)";
                     }
                 }
                 if ($valStr) {
                     $sql = "INSERT INTO $tabName ($keyStr)  VALUES $valStr ";
                        echo $sql.";" ;
//                     $tabArr = $this->mssdb->runSqldata($sql);

//                     sleep(0.0001);
                 }
             }
             unset($allData);
         }

    }



    public function actionGetcol(){

        $tabArr = $this->mssdb->getTabColumn($this->tabname) ;
    }
    public function getFileCont()
    {
        ini_set('memory_limit', '1000M');
        $logPath = Yii::$app->params['filePath']; //文件保存目录


        if(isset($_GET['type'])){
            $type = $_GET['type'] ;
            if($type==1){
                $logPath =  Yii::$app->params['path1'];
            }
            if($type==2){
                $logPath =  Yii::$app->params['path2'];
            }
            if($type==3){
                $logPath =  Yii::$app->params['path3'];
            }

        }

        $fileName = $logPath . $_GET['file'];

        $cont = file_get_contents($fileName);
        $datas = explode("\n", $cont);


        unset($cont);
        $nums = count($datas) ;
        $lenNum = 3000 ;

        if($nums>$lenNum){
            $length = ceil($nums/$lenNum);
            for($i=0;$i<$length;$i++){
                for($k=0;$k<$lenNum;$k++){
                    $start = $k+$i*$lenNum;
                    $newArr[$i][]=$datas[$start];
                }
            }
        }else{
            $newArr = array($datas) ;
        }
        unset($datas) ;

        $logArr = array(
            'log_account', 'log_character', 'log_login', 'log_logout', 'log_recharge',
            'log_yuanbao',    'log_item','log_uplevel','log_consumption',
            'log_stage',    'log_card_gain','log_card_train','log_horse_tame','log_equip',
            'log_skill_up', 'log_jingjie_up','log_killboss', 'log_dungeon', 'log_marry',
        );

        foreach ($newArr as $k => $v) {
            $allData = array();
            foreach ($v as $k1=>$v1) {
                if ($json = json_decode($v1)) {

                    $tmpData = $this->objeToArr($json);
                    $name = $tmpData['f_log_name'];//
                    if(in_array($name,$logArr)){
                        $allData[$name][] = $this->createData($name, $tmpData);
                    }
                }
            }
            foreach ($allData as $tabName => $v2) {
                 $keyStr = $this->getCol($tabName);
                $valStr = '';
                foreach ($v2 as $item) {
                    $tmpStr = implode(',', $item);
                    if ($valStr != null) {
                        $valStr .= ",($tmpStr)";
                    } else {
                        $valStr .= "($tmpStr)";
                    }
                }
                if ($valStr) {
                    $sql = "INSERT INTO $tabName ($keyStr)  VALUES $valStr ";
//                    echo $sql ;
                    $tabArr = $this->mssdb->runSqldata($sql);
                    sleep(0.002);
                }
            }
            unset($allData);
        }
    }


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
            case 'log_skill_up':
                $keyStr ="f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_model_id,f_level_num,f_goods_num";
                break ;
            case 'log_card_train':
                $keyStr ="f_dept,f_server_address_id,f_game_id,f_time,f_sid,f_yunying_id,f_character_id,f_character_grade,f_character_ip,f_model_id,f_id,f_card_color,f_card_num,f_jingyan_num,f_card_before,f_card_after";
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
                        $tmp =$data['f_stage_ns']=='n'?1:2,
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
                    $tmp = $data['f_yuanbao_num']?$data['f_yuanbao_num']:0,

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
//                $keyStr ="f_m_yunying_id,f_w_yunying_id,f_m_character_id,f_w_character_id,f_m_character_grade,f_w_character_grade,f_m_character_ip,f_w_character_ip,f_lovetoken_id";

                $data2 = array(
                    $data['f_dept'],
                    $data['f_server_address_id'],
                    $data['f_game_id'],
                    "'".date("Y-m-d H:i:s",$data['f_time'])."'",
                    $data['f_sid'],

                    "'".$data['f_m_yunying_id']."'",
                    "'".$data['f_w_yunying_id']."'",
                    $data['f_m_character_id'],
                    $data['f_w_character_id'],
                    $data['f_m_character_grade'],
                    $data['f_w_character_grade'],
                    $t.$data['f_m_character_ip'].$t,
                    $t.$data['f_w_character_ip'].$t,
                    $data['f_lovetoken_id'],
                );
                break ;
            //f_model_id,f_level_num,f_goods_num
            case 'log_skill_up':
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
                    $data['f_level_num'],
                    $data['f_goods_num']
                );
                break ;
            case 'log_card_train':
                //f_model_id,f_id,f_card_color,f_card_num,f_jingyan_num,f_card_before,f_card_after";
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
                    $data['f_card_color'],
                    $data['f_card_num'],
                    $data['f_jingyan_num'],
                    $data['f_card_before'],
                    $tmp = $data['f_card_after']?$data['f_card_after']:0,
                );
                break ;
        }
        return $data2 ;
    }
    public function actionCleardata(){

//        $data =  $this->mssdb->clear();

    }
}