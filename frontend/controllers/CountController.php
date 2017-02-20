<?php

namespace frontend\controllers;


use Yii ;

class CountController extends CommController
{
    public function actionRecharge()
    {
        $etime = $this->getStrart() ;
        $stime =   $etime-86400*31  ;
        $clo = array('id','日期','登录人数','充值人数','充值金额','ARPU','ARPPU','付费率','新增人数','新增充值人数','新增充值金额','新增ARPU','新增ARPU','新增付费率') ;
        $sql = "SELECT * FROM bi_count_recharge  where f_time>=$stime and  f_time<=$etime
                and recharge_num>0 limit 7" ;

        $command = Yii::$app->db->createCommand($sql);

        $dataAll  = $command->queryAll() ;
        foreach($dataAll as $k=>$v){
            $dataAll[$k]['f_time'] = date("Y-m-d",$v['f_time'] ) ;
            foreach($v as $key1=>$val1){
                if($k=='arpu'||$k=='arppu'||$k=='new_arpu'||$k=='new_arppu'){
//                    if(stristr('.',$v)){
//                        $tmp = explode('.',$v) ;
//                        $dataAll[$k][$key1]= $tmp[0]
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
