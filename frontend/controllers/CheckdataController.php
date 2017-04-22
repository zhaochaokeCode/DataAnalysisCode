<?php

namespace frontend\controllers;

require_once "../lib/testdb.php" ;
use testdb ;

use Yii ;
use yii\web\Controller;


class CheckdataController extends Controller
{
    public function actionIndex()
    {
        $this->sqlserver = new testdb();
        $hostname = "172.16.60.199";
        $port = 1433;
        $dbname = "taohua_log";
        $username = "zck";
        $pw = "zck";
        $db = new PDO ("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$pw");




    }

//        foreach($datas as $key=>$val){
//            if($val) {
//                if ($tmp = json_decode($val)) {
//                    $tmpData = $this->objeToArr($tmp);
////                    if($tmpData['f_time']<1492704000||$tmpData['f_time']>1492704000){
////                        continue ;
////                    }
//                    $newArr[] = $tmpData;
//
//                    $logName = $tmpData['f_log_name'];
//                    $time    = date("Y-m-d",$tmpData['f_time']) ;
//                    $arrayNum[$logName][$time]++;
//                    if($logName=='log_recharge'){
//                        $rechar[$logName][$time]['money'] = $tmpData['f_rechage_money'];
//
//                    }
//                } else {
//
//                }
//            }
//        }
//        $tabName='log_check' ;
//
//        foreach($arrayNum as $key=> $value){
//
//            foreach($value as $date =>$num) {
//
//                $sql = "select * from log_check where log_name ='$key' and time='$date'";
//
//                $command = Yii::$app->db5->createCommand($sql);
//                $datas2 = $command->queryOne();
//                if($datas2){
//                    $num = $datas2['log_num']+$num ;
//                    $data = array(
//                        'log_num'=>$num
//                    ) ;
//                    if($key=='log_recharge'){
//                        $newMoeny = $rechar[$key][$time]['money']  ;
//                        $data['log_money'] =$newMoeny + $datas2['log_money'] ;
//                    }
//                    Yii::$app->db5->createCommand()->update($tabName, $data, array('id' => $datas2['id']))->execute();
//                }else{
//                    $array = array(
//                            "log_name"=>$key ,
//                            "log_num"=>$num ,
//                            "time"=>$date,
//                            ) ;
//                    if($key=='log_recharge'){
//                        $newMoeny = $rechar[$key][$time]['money']  ;
//                        $data['log_money'] =$newMoeny  ;
//                    }
//                    $result= Yii::$app->db5->createCommand()->insert($tabName,$array)->execute() ;
//                    if(!$result){
//                        echo 'fail' ;
//                    }
//
//                }
//            }
//
//
//
//
//
//        }
////
////
//        if(($tmp1 = count($datas)-count($newArr))>2){
//            $array = array(
//                "log_name"=>$_GET['file_name']  ,
//            ) ;
//            $result= Yii::$app->db5->createCommand()->insert($tabName,$array)->execute() ;
//        }
//
//    }
//
//    public function objeToArr($object)
//    {
//        $array = array();
//        if (is_object($object)) {
//            foreach ($object as $key => $value) {
//                if ($key == 'f_params') {
//                    if ($value) {
//                        foreach($value as $k1=>$v1){
//                            $tmpArr[$k1] =$v1 ;
//                        }
//                        $array = $array + $tmpArr;
//                    }
//                } else {
//                    $array[$key] = $value;
//                }
//            }
//        } else {
//            $array = $object;
//        }
//        return $array;
//    }

}
