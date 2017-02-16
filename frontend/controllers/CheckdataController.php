<?php

namespace frontend\controllers;


use Yii ;
use yii\web\Controller;


class CheckdataController extends Controller
{
    public function actionIndex()
    {
        $data = '/data/flume_logs/skill_log/1486277205420-240' ;
        $cont = file_get_contents($data) ;

        $datas = explode("\n", $cont);
        $tmp =array( );

        foreach($datas as $v){
            if ($json = json_decode($v)) {
                $tmpData = $this->objeToArr($json);
                if (!in_array($tmpData['f_log_name'],$tmp)){
                    $tmp[] = $tmpData['f_log_name'];
                    $add[$tmpData['f_log_name']] = 0 ;
                    $res = $v ;
                }else{
                    $add[$tmpData['f_log_name']]++ ;
                }
            }
        }
        var_dump($add) ;echo "<br><br>" ;var_dump($res);
    }
    function objeToArr($object)
    {
        $array = array();
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                if ($key == 'f_params') {
                    if ($value) {
                        $array = array_merge($array, $this->objeToArr($value));
                    }
                } else {
                    $array[$key] = $value;
                }
            }
        } else {
            $array = $object;
        }

//        print_r($array) ;die;
        return $array;

    }

}
