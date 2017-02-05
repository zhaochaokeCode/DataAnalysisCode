<?php

namespace frontend\controllers;


use Yii ;
class RetentionController extends CommController
{
    public function actionIndex()
    {
        $viAndTa =  $this->createViewAndTabData();


        return $this->render("//index/getdatas.php",[
            "all_data"=>array()
        ]);
    }


    /**
     * 根据原始数据生成视图数据和表格数据
     */
    public function createViewAndTabData(){
        $this->initDb();




    }
    /**
     * 数据入库函数,当数据需要初始化的时候生成
     */
    public function initDb()
    {
        $connection = Yii::$app->db;

        $time =time()-86400*30;
        for($i=0;$i<30;$i++){

            //30天前开始算
            $start       = strtotime(date("Y-m-d",$time+86400*$i));
            //有日志的第二天id
            $end         = $start+86400*($i+1);


            $secStr      = $start+86400*1;
            $threeSta    = $start+86400*3 ;
            $seventime   = $start+86400*7 ;
            $fivthtime   = $start+86400*15 ;
            $thirtytime  = $start+86400*30 ;



            //当天注册的用户
            $sql = "SELECT f_character_id id from bi_log_character WHERE f_time>=$start AND f_time<$end
                        " ;

            $command = $connection->createCommand($sql);
            $result = $command->queryAll();

            $tag ="<br><br>" ;
            $two = $three = $seven = $f_fifteen_day = $thirty =0.00 ;
            if($result) {
                echo date("Y-m-d",$start).$tag ;
                foreach($result as $v){
                    $idArr[] =  $v['id'] ;
                }
                $allNum = count($idArr) ;
                $regStr= implode(',',$idArr) ;

                //次日留存
                if($i<29){
                    $two = $this->runSql($secStr,$thirtytime,$regStr,$connection,$allNum) ;
                }
                //三日留存
                if($i<27){
                    $three = $this->runSql($threeSta,$thirtytime,$regStr,$connection,$allNum) ;
                }
                //七日留存
                if($i<23){
                    $seven = $this->runSql($seventime,$thirtytime,$regStr,$connection,$allNum) ;
                }
                //十五日留存
                if($i<15){
                    $f_fifteen_day = $this->runSql($fivthtime,$thirtytime,$regStr,$connection,$allNum) ;
                }
                //30日留存
                if($i<1){
                    $thirty = $this->runSql($fivthtime,$thirtytime,$regStr,$connection,$allNum) ;
                }

            }
            $data = array(
                'f_tow_day'=>$two ,
                'f_three_day'=>$three ,
                'f_seven_day'=> $seven,
                'f_fifteen_day'=>$f_fifteen_day,
                'f_thirty_day'=>$thirty ,
                'f_time'=>$start
            ) ;
            var_dump($data);
            $tabName = 'bi_count_retention';
            $sql = "select id from $tabName where f_time ='$start'" ;
            $command = $connection->createCommand($sql);
            $result = $command->queryOne();
            if($result['id']){
                $connection->createCommand()->update($tabName,$data,array('id'=>$result['id']))->execute() ;
                echo 'update' ;
            }else {
                $connection->createCommand()->insert($tabName,$data)->execute() ;
                echo 'insert' ;
            }
        }

    }
    private function runSql($staTime,$endTime,$regStr,$connection,$all){
        $sql = "SELECT count(DISTINCT(f_character_id)) num from bi_log_login
                            WHERE f_time>=$staTime AND f_time<$endTime and f_character_id in($regStr)
                        ";
        $command = $connection->createCommand($sql);
        $result = $command->queryOne();
        if($result['num']){
            $num = round($result['num']/$all,2) ;
        }else {
            $num = 0.00;
        }
        return $num ;
    }

}
