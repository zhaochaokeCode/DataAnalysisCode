<?php

namespace frontend\controllers;


use Yii ;

class CountController extends CommController
{
    public function actionRecharge()
    {
        $etime = $this->getStrart() ;
        $stime =   $etime-86400*31  ;
        $clo = array('日期','登录人数','充值人数','充值金额','ARPU','ARPPU','付费率','新增人数','新增充值人数','新增充值金额','新增ARPU','新增ARPU','新增付费率') ;
        $sql = "SELECT * FROM bi_count_recharge  where f_time>=$stime and  f_time<=$etime
                and f_recharge_num>0 limit 7" ;

        $command = Yii::$app->db->createCommand($sql);

        $dataAll  = $command->queryAll() ;




        foreach($dataAll as $k=>$v){
            unset($dataAll[$k]['id']) ;
            $dataAll[$k]['f_time'] = date("Y-m-d",$v['f_time'] ) ;
            foreach($v as $key1=>$val1){
                if($key1=='arpu'||$key1=='arppu'||$key1=='new_arpu'||$key1=='new_arppu')
                {
                    $val1 =$val1*100 ;
                    if($val1<99){
                        if($val1<10){
                            $newVal = "0.0".$val1 ;
                        }else{
                            $newVal = "0.".$val1 ;
                        }
                    }else{
                        $newVal=1000;
                        $start= substr($val1,-2,2) ;
                        $end  = substr($val1,-strlen($val1),strlen($val1)-2) ;
                        $newVal =$end .".".$start ;
                    }
                    $dataAll[$k][$key1]= $newVal ;
                }
                if($key1=='fufei'||$key1=='new_fufei'){
                    $newVal ="$newVal%" ;
                    $dataAll[$k][$key1]= $newVal ;
                }

            }

        }


        array_unshift($dataAll,$clo);
        $datas[0]['tab']  =  json_encode($dataAll);
        $datas[0]['count']  = 10 ;
        return $this->render("//index/getdatas.php",[
            "all_data"=>$datas
        ]);

    }

}
