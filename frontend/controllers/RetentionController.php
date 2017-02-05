<?php

namespace frontend\controllers;


use Yii ;
class RetentionController extends CommController
{
    public  $tabName = 'bi_count_retention';
    public function actionIndex()
    {
        $viAndTa =  $this->createViewAndTabData();
        return $this->render("//index/getdatas.php",[
            "all_data"=>$viAndTa
        ]);
    }


    /**
     * 根据原始数据生成视图数据和表格数据
     */
    public function createViewAndTabData(){
        $connection = Yii::$app->db;
//        $this->initDb($connection);

        $where = $this->getWhere() ;
        $where .= " and f_tow_day>0 " ;
        $sql = "SELECT f_time,f_tow_day,f_three_day,f_seven_day,
                f_fifteen_day,f_thirty_day
            from $this->tabName $where order by f_time asc limit 7 " ;
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        if($result){
            foreach($result as $v){
                $towDay[]        = doubleval($v['f_tow_day']/100) ;
                $threeDay[]      = doubleval($v['f_three_day']/100)  ;
                $sevenDay[]      = doubleval($v['f_seven_day']/100)  ;
                $fifteenDay[]    = doubleval($v['f_fifteen_day']/100)  ;
                $thirtyDay[]     = doubleval($v['f_thirty_day']/100)  ;
                $date            = date("Y-m-d",$v['f_time']) ;
                $categories[]    = $date;
                $tabArr[]  = array(
                    $date,$v['f_tow_day']/100,$v['f_three_day']/100,
                    $v['f_seven_day']/100,$v['f_fifteen_day']/100,
                    $v['f_thirty_day']/100
                ) ;
            }
            $count = count($result) ;
            $allGame = array(array(
                'count' => $count,
                'categories' => json_encode($categories),
                'series' =>array($towDay,$threeDay,$sevenDay,$fifteenDay,$thirtyDay), //这个还需要重新分配数组,如果是多维度
                'tab' => $tabArr
            ));


            $conDatas = Yii::$app->params['tabConfig'];
//            $key = $_GET['action'];
            $key = 'retention' ;
            $configDatas = $conDatas['gamePlayer'][$key];


            foreach ($configDatas['tab_all'] as $k => $v) {
                array_unshift($allGame[$k]['tab'], $v['thred']);
                $allGame[$k]['tab'] = json_encode($allGame[$k]['tab']); //tab的时间标示
                //这个还得去大数组中去取
                $allGame[$k]['tag'] = $configDatas['tag'][$k];

                //为每个数据视图线提供数据名称
                $nameArr = $configDatas['tag'][$k]['name'] ;

                //---关键性数据----为每个视图生成seri数据
                foreach($nameArr as $key1=>$val1){
                    $tmArr[] = array(
                        'name'=>$val1,
                        'data'=>$allGame[$k]['series'][$key1]
                    );
                }
                $allGame[$k]['series'] = json_encode($tmArr) ;
            }
            return $allGame ;
        }





    }
    /**
     * 数据入库函数,当数据需要初始化的时候生成
     */
    public function initDb($connection)
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
            $two = $three = $seven = $f_fifteen_day = $thirty =0 ;
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
                'f_time'=>$start,

                //预留一下 平台
            ) ;
            $tabName = $this->tabName ;
            $sql = "select id from $tabName where f_time ='$start'" ;
            $command = $connection->createCommand($sql);
            $result = $command->queryOne();
            if($result['id']){
                $connection->createCommand()->update($tabName,$data,array('id'=>$result['id']))->execute() ;
//                echo 'update' ;
            }else {
                $connection->createCommand()->insert($tabName, $data)->execute();
//                echo 'insert' ;
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
            $num = round($result['num']/$all,2)*100 ;
        }else {
            $num = 0;
        }
        return $num ;
    }

}
