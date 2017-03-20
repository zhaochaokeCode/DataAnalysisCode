<?php
namespace frontend\controllers;
require_once '../lib/mss.php' ;
use Yii;
use mss ;
header("Content-type: text/html; charset=utf-8");
/**
 * Site controller
 */
class SiteController extends CommController
{
    public $layout = false;

    public $cusKey = false;
    public $valArr;

    public $days = 7;

    public $mssdb ='' ;

    public function init()
    {
        $this->mssdb =  new mss() ;
    }


    /**
     *流失加留存
     */
    public function actionCount(){
        //
        $this->initDb();
        $this->createLogOut($this->days);

        return;
    }





    /**
     * 初始化recharge
     */
    public function actionRecharge()
    {
        $key =100;
        $tabName = "bi_count_retention";
        $connection = Yii::$app->db;
        $strtime = $this->getStrart() ;
        for ($i = 0; $i <$key; $i++) {
            $stime = $strtime-86400*$i ;
            $etime = $strtime+86400 ;
            //  充值人数,充值元宝,登录人数,新增(注册人数),
            $sql = " select count(DISTINCT(a.f_character_id)) recharge_hum_num,
                    COUNT(f_recharge_yuanbao) recharge_num,
                    (SELECT count(DISTINCT(f_character_id))id from bi_log_login where f_time>$stime and f_time<$etime)login_hum_num ,
                    (SELECT count(DISTINCT(f_character_id))id from bi_log_character where f_time>$stime and f_time<$etime)regist_hum_num
                    from bi_log_recharge a where f_time>$stime and f_time<$etime" ;

            $command = Yii::$app->db->createCommand($sql);
            $datas = $command->queryOne();
//            if($datas['recharge_hum_num']) {
                //新增充值人数
                $sql1 = "select count(DISTINCT(a.f_character_id)) new_recharge_hum_num,
                    count(f_recharge_yuanbao) new_recharge_num  from bi_log_recharge a where
                      f_time>$stime and f_time<$etime and  f_character_id in(SELECT f_character_id from bi_log_character
                      where  f_time>$stime and f_time<$etime)
                    ";
                $command = Yii::$app->db->createCommand($sql1);
                $datas2 =  $command->queryOne();

                $datas = $datas+ $datas2 ;



                $a = $datas['recharge_num']==0?0:  sprintf("%.2f",$datas['recharge_num']/$datas['login_hum_num']);
                $b = $datas['recharge_num']==0?0:  sprintf("%.2f",$datas['recharge_num']/$datas['recharge_hum_num']) ;
                $c = $datas['recharge_num']==0?0:sprintf("%.2f",$datas['recharge_hum_num']/$datas['login_hum_num']);

                $d = $datas['recharge_num']==0?0:  sprintf("%.2f",$datas['new_recharge_num']/$datas['regist_hum_num']) ;
                $e = $datas['recharge_num']==0?0:  sprintf("%.2f",$datas['new_recharge_num']/$datas['new_recharge_hum_num']) ;
                $f = $datas['recharge_num']==0?0:sprintf("%.2f",$datas['new_recharge_hum_num']/$datas['regist_hum_num']);




            $sql4 ="DESC bi_count_recharge" ;
            $command = Yii::$app->db->createCommand($sql4);
            $datas3 =  $command->queryAll();
            foreach($datas3 as $v){
                if($v['Field']!='id'){
                    $tmp[] = $v['Field'];
                }
            }
                $insertData= array(
                    $tmp[0]=> $stime,
                    $tmp[1]=>$datas['login_hum_num'],
                    $tmp[2]=> $datas['recharge_hum_num'],
                    $tmp[3]=>$datas['recharge_num'],
                    $tmp[4]=>$a,
                    $tmp[5]=>$b,
                    $tmp[6]=>$c,
                    $tmp[7]=>$datas['regist_hum_num'],

                    $tmp[8]=>$datas['new_recharge_hum_num'],
                    $tmp[9]=>$datas['new_recharge_num'],
                    $tmp[10]=>$d,
                    $tmp[11]=>$e,
                    $tmp[12]=>$f
                );
            Yii::$app->db->createCommand()->insert("bi_count_recharge", $insertData)->execute();
//            }

        }
    }

    /**
     * @throws 初始化所有数据
     */

    public function actionIndex()
    {
        ini_set('memory_limit', '1024M');
        if (!isset($_GET['create_data'])) return;
        $sinkFile = Yii::$app->params['runFile'];//中间通道数据文件路径
        $logPath = Yii::$app->params['tmpFilePath']; //文件保存目录
        $logType = array();
        $ret = array();

        //获取mysql的表名
        $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'data_analysis'";
        $command = Yii::$app->db->createCommand($sql);
        $posts = $command->queryAll();
        foreach ($posts as $v) {
            $tabArr[] = $v['TABLE_NAME'];
        }

        //得到中间通道文件中保存的文件名称
        $contFile = file_get_contents($sinkFile);
        $fileArr = explode("\n", $contFile);
        $lessArr = array();
//        var_dump($fileArr) ;


        //读取每个文件并保存到数据库
        foreach ($fileArr as $v) {
            $allData =array() ;
            $fileName = $logPath . $v;
            $cont = file_get_contents($fileName);

            $datas = explode("\n", $cont);
            unset($cont);

            foreach ($datas as $k => $v) {
                if ($v) {
                    if ($json = json_decode($v)) {
                        $tmpData = $this->objeToArr($json);

                        //去掉不需要保存的表名,保留唯一一次的表名
                        $name = $tmpData['f_log_name'];
                        unset($tmpData['f_log_name']) ;

                        if(!$keyData[$name]){
                            $keyData[$name] = array_keys($tmpData) ;
                        }

                        //对所有数据进行相同的排序
                        foreach($keyData[$name]  as $v){
                            $newArr[$v] = $tmpData[$v];
                        }
                        $allData[$name][] = array_values($newArr) ;
                    }
                }
            }
            foreach($allData as $k=>$v) {
                if (count($v[0])>1) {
                    $valStr = '';
                    $tabName = 'bi_' . $k;
                    $keyStr = implode(',', $keyData[$k]);
                    $coluNum = count($keyData[$k]); //一共多少列

                    foreach ($v as $v3) {
                        if ($coluNum != count($v3)) {
//                            var_dump($keyData[$k]);
//                            echo "<br>";
//                            echo "<br><br>";
                            continue;
                        }


                        foreach ($v3 as $k4 => $v4) {
                            if ($v4 != 'null' && $v4 != 'default') {
                                $v3[$k4] = "'$v4'";
                            }
                        }

                        $tmpStr = implode(',', $v3);
                        if ($valStr!=null) {
                            $valStr .= ",($tmpStr)";
                        } else {
                            $valStr .= "($tmpStr)";
                        }


                    }
                    if($valStr) {
                        $sql = "INSERT INTO $tabName ($keyStr)  VALUES $valStr ";

                        $connection = Yii::$app->db;
                        $command = $connection->createCommand($sql);
                        $res = $command->execute();
                    }
                }
            }
            sleep(1.0);
        }

        unset($datas);

    }



    /**
     * 留失分析数据统计
     */
    public function initDb()
    {
        $tabName = "bi_count_retention";
        $connection = Yii::$app->db;
        $time = time() - 86400 * 30;
        for ($i = 0; $i < 30; $i++) {

            //30天前开始算
            $start = strtotime(date("Y-m-d", $time + 86400 * $i));
            //有日志的第二天id
            $end = $start + 86400 * ($i + 1);


            $secStr = $start + 86400 * 1;
            $threeSta = $start + 86400 * 3;
            $seventime = $start + 86400 * 7;
            $fivthtime = $start + 86400 * 15;
            $thirtytime = $start + 86400 * 30;

            //当天注册的用户
            $sql = "SELECT f_character_id id from bi_log_character WHERE f_time>=$start AND f_time<$end
                        ";

            $command = $connection->createCommand($sql);
            $resultAll = $command->queryAll();


            $tag = "<br><br>";
            $two = $three = $seven = $f_fifteen_day = $thirty = 0;
            if ($resultAll) {
                echo date("Y-m-d", $start) . $tag;
                foreach ($resultAll as $v) {
                    $idArr[] = $v['id'];
                }
                $allNum = count($idArr);
                $regStr = implode(',', $idArr);

                //次日留存
                if ($i < 29) {
                    $two = $this->runSql($secStr, $thirtytime, $regStr, $connection, $allNum);
                }
                //三日留存
                if ($i < 27) {
                    $three = $this->runSql($threeSta, $thirtytime, $regStr, $connection, $allNum);
                }
                //七日留存
                if ($i < 23) {
                    $seven = $this->runSql($seventime, $thirtytime, $regStr, $connection, $allNum);
                }
                //十五日留存
                if ($i < 15) {
                    $f_fifteen_day = $this->runSql($fivthtime, $thirtytime, $regStr, $connection, $allNum);
                }
                //30日留存
                if ($i < 1) {
                    $thirty = $this->runSql($thirtytime - 86400, $thirtytime, $regStr, $connection, $allNum);
                }

            }
            $data = array(
                'f_tow_day' => $two,
                'f_three_day' => $three,
                'f_seven_day' => $seven,
                'f_fifteen_day' => $f_fifteen_day,
                'f_thirty_day' => $thirty,
                'f_time' => $start,
                'f_type' => 1
                //预留一下 平台
            );

            $sql = "select id from $tabName where f_time ='$start' and f_type=1";
            $command = $connection->createCommand($sql);
            $result = $command->queryOne();
            if ($result['id']) {
                $connection->createCommand()->update($tabName, $data, array('id' => $result['id']))->execute();
            } else {
                $connection->createCommand()->insert($tabName, $data)->execute();
            }

            if ($resultAll) {
                echo date("Y-m-d", $start) . $tag;
                foreach ($resultAll as $v) {
                    $idArr[] = $v['id'];
                }
                $allNum = count($idArr);
                $regStr = implode(',', $idArr);

                //次日留存
                if ($i < 29) {
                    $two = $this->runSql($secStr, $secStr + 86400, $regStr, $connection, $allNum);
                }
                //三日留存
                if ($i < 27) {
                    $three = $this->runSql($threeSta, $threeSta + 86400, $regStr, $connection, $allNum);
                }
                //七日留存
                if ($i < 23) {
                    $seven = $this->runSql($seventime, $seventime + 86400, $regStr, $connection, $allNum);
                }
                //十五日留存
                if ($i < 15) {
                    $f_fifteen_day = $this->runSql($fivthtime, $fivthtime + 86400, $regStr, $connection, $allNum);
                }
                //30日留存
                if ($i < 1) {
                    $thirty = $this->runSql($thirtytime, $thirtytime + 86400, $regStr, $connection, $allNum);
                }

            }
            $data = array(
                'f_tow_day' => $two,
                'f_three_day' => $three,
                'f_seven_day' => $seven,
                'f_fifteen_day' => $f_fifteen_day,
                'f_thirty_day' => $thirty,
                'f_time' => $start,
                'f_type' => 2
                //预留一下 平台
            );
            $sql = "select id from $tabName where f_time ='$start' and f_type=2";
            $command = $connection->createCommand($sql);
            $result = $command->queryOne();
            if ($result['id']) {
                $connection->createCommand()->update($tabName, $data, array('id' => $result['id']))->execute();
            } else {
                $connection->createCommand()->insert($tabName, $data)->execute();
            }
        }

    }

    private function runSql($staTime, $endTime, $regStr, $connection, $all)
    {
        $sql = "SELECT count(DISTINCT(f_character_id)) num from bi_log_login
                            WHERE f_time>=$staTime AND f_time<$endTime and f_character_id in($regStr)
                        ";
        $command = $connection->createCommand($sql);
        $result = $command->queryOne();
        if ($result['num']) {
            $num = round($result['num'] / $all, 2) * 100;
        } else {
            $num = 0;
        }
        return $num;
    }

    /**
     * 生成登录统计数据
     */
    public function insertDb($connection)
    {
        for ($i = 0; $i < 30; $i++) {
            $start = strtotime(date("Y-m-d", strtotime("-$i day")));
            $end = strtotime(date("Y-m-d", time() - 86400 * ($i - 1)));

            $sql = "SELECT count(DISTINCT(f_character_id)) num from bi_log_login
                            WHERE f_time>=$start AND f_time<$end
                        ";
            $command = $connection->createCommand($sql);
            $allDatas = $command->queryAll();
            if ($allDatas) {
                echo date("Y-m-d", $start) . $sql . "<br><br>";
                foreach ($allDatas as $v) {
                    $tabName = "bi_count_login";
                    if ($v['num']) {
                        $data = array(
                            'f_time' => $start,
                            'num' => $v['num'],
                        );
                        $connection->createCommand()->insert($tabName, $data)->execute();
                    }
                }

            }

        }

    }

    /**
     *用户的退出
     */
    public function createLogOut($key = 30)
    {
        for ($i = 0; $i < $key; $i++) {
            $startTime = $this->getStrart() - 86400 * $i;
            $endTime = $startTime + 86400;

            $sql = "SELECT distinct(f_character_id) id from bi_log_character where  f_time>=$startTime AND f_time<$endTime";
            $command = Yii::$app->db->createCommand($sql);
            $allRegist = $command->queryAll();
            if (!$allRegist) continue;
            foreach ($allRegist as $v) {
                $strArr[] = $v['id'];
            }
            $inStr = implode(',', $strArr);

            $nsArr = $this->getLogoutData('f_nstage_id', 1, $startTime, $endTime, $inStr);
            $ssArr = $this->getLogoutData('f_sstage_id', 2, $startTime, $endTime, $inStr);
            $valArr = $nsArr + $ssArr;
            Yii::$app->db->createCommand()->batchInsert('bi_count_logout', $this->cusKey, $valArr)->execute();
        }


    }

    private function getLogoutData($nsId, $type, $startTime, $endTime, $inStr)
    {
        $lastSql = "select id,f_dept,$nsId,f_sid,f_game_id,f_character_id,max(f_time) from bi_log_logout WHERE
                  f_time>=$startTime AND f_time<$endTime and f_character_id in($inStr) group by
                  f_sid, f_game_id,f_dept,$nsId order by f_time asc ";

        //---退出剧情id和数量
        $sql = "SELECT $nsId f_out_id,count(a.$nsId) f_out_num,a.f_sid,a.f_game_id,a.f_dept from ($lastSql) as a
                        group by f_sid, f_game_id,$nsId,f_dept  ";
        $command = Yii::$app->db->createCommand($sql);
        $allDatas = $command->queryAll();
        if ($type == 2) echo $sql . "<br><br>";
        if (!$this->cusKey) {
            $this->cusKey = array_keys($allDatas[0]);
            $this->cusKey[] = 'f_time';
            $this->cusKey[] = 'f_type';
        }
        $ret = array();
        foreach ($allDatas as $v) {
            $v[] = $startTime;
            $v[] = $type;
            $ret[] = array_values($v);
        }
        return $ret;

    }






}
