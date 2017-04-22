<?php

namespace frontend\controllers;


use Yii ;
use yii\web\Controller;


class CheckdataController extends Controller
{
    public function actionIndex()
    {
        $path = '/data/flume_logs/check/' ;
        $file_name = $path.$_GET['file_name'] ;
        $tmpFile = file_get_contents($file_name) ;

        $datas = explode("\n", $tmpFile);

        echo count($datas)."<br>" ;

        foreach($datas as $key=>$val){
            if($val) {
                if ($tmp = json_decode($val)) {
                    $tmpData = $this->objeToArr($tmp);
                    $newArr[] = $tmpData;

                    $logName = $tmpData['f_log_name'];
                    $time    = date("Y-m-d",$tmpData['f_time']) ;


                    $arrayNum[$logName][$time]++;
                } else {
                    echo $key;
                    echo $val . "<br>";
                    echo 'fail';
                    sleep(10000);
                    break;
                }
            }
        }

        foreach($arrayNum as $key=> $value){


            $sql = 'select * from log_check where 1';

            $command = Yii::$app->db5->createCommand($sql);
            $datas2 =  $command->queryOne();

            var_dump($datas2) ;die;


//            $result= Yii::$app->db3->createCommand()->insert($table,$data)->execute() ;

        }
//        echo count($newArr)."<br>" ;
//
//        if(count($datas)>count($newArr)){
//            echo 'error'."<br>" ;
//            sleep(100);
//        }
//        var_dump($arrayNum) ;

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

}
