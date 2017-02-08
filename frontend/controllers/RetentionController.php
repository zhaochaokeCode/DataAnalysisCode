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
     *
     * 获取数据和格式化数据
     *
     */
    public function createViewAndTabData(){
        $connection = Yii::$app->db;
//        $this->initDb($connection);

        $type= $_GET['type']?2:1 ;
        $where = $this->getWhere()." and f_type=$type " ;

        $where .= " and f_tow_day>0 " ;
        $sql = "SELECT f_time,f_tow_day,f_three_day,f_seven_day,
                f_fifteen_day,f_thirty_day
            from $this->tabName $where order by f_time asc limit 7 " ;
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        if($result) {
            foreach ($result as $v) {
                $towDay[] = doubleval($v['f_tow_day'] / 100);
                $threeDay[] = doubleval($v['f_three_day'] / 100);
                $sevenDay[] = doubleval($v['f_seven_day'] / 100);
                $fifteenDay[] = doubleval($v['f_fifteen_day'] / 100);
                $thirtyDay[] = doubleval($v['f_thirty_day'] / 100);
                $date = date("Y-m-d", $v['f_time']);
                $categories[] = $date;
                $tabArr[] = array(
                    $date, $v['f_tow_day'] / 100, $v['f_three_day'] / 100,
                    $v['f_seven_day'] / 100, $v['f_fifteen_day'] / 100,
                    $v['f_thirty_day'] / 100
                );
            }
            $count = count($result);
            $allGame = array(array(
                'count' => $count,
                'categories' => json_encode($categories),
                'series' => array($towDay, $threeDay, $sevenDay, $fifteenDay, $thirtyDay), //这个还需要重新分配数组,如果是多维度
                'tab' => $tabArr
            ));
            $type= $_GET['type']?'retention':'retention_lost' ;
            return $this->createData($allGame,$type);
        }

    }


}
