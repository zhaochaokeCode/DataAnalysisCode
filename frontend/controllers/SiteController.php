<?php
namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends CommController
{
    public $layout = false;

    public $cusKey = false;
    public $valArr;

    public $days = 7;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

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
            $lessArr = array();
//            foreach ($datas as $v) {
//                if ($json = json_decode($v)) {
//                    $tmpData = $this->objeToArr($json);
//                    $moreArr = array();
//                    $data[$tmpData['f_log_name']][] = $tmpData ;
//                    $sqlData = $this->createSqlData($tmpData, $lessArr, true, $moreArr);
////                    sleep(0.1) ;s
//                }
//            }
//        }
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

        //流失加留存
        $this->initDb();

        $this->createLogOut($this->days);
        return;
    }


//            while (($file = readdir($current_dir)) !== false) {
//                if ($file == '.' || $file == '..') {
//                    continue;
//                } else if (is_dir($file)) {    //如果是目录,进行递归
//                } else {
//                    $fileName = $path . '/' . $file;
//                    $cont = file_get_contents($fileName);
//                    $datas = explode("\n", $cont);
//
//
//                    $lessArr = array();
//                    foreach ($datas as $v) {
//                        if ($json = json_decode($v)) {
//                            $tmpData = $this->objeToArr($json);
//                            $tag = true;
//                            if (isset($json->f_params)) {
//                                $tmp2 = array();
//                                foreach ($json->f_params as $k => $v) {
//                                    $tmp2[$k] = $v;
//                                }
//                                if (!$tmp2) $tag = false;
//                                $tmp1 = $this->objeToArr($json->f_params);
//                                if (count($tmp1) > 5) {
//                                }
//
//                            }
//                        if($tmpData['f_log_name']=='log_online_character_cnt'){
//                            print_r($tmpData) ;die;
//                        }
//                        continue ;
//                            $moreArr = array();
//                            $sqlData = $this->createSqlData($tmpData, $lessArr, $tag, $moreArr);
//                        }
//                    }
//                }
//            }
//        }
//                            continue;
//                            $tmp = array_keys($logType);

//                            if (($name = $useData['f_log_name'])) {
//                                if ($name == 'log_online_character_cnt') $name = 'log_onlineinfo';
//                                $tabName = 'bi_' . $name;


//                            if (!in_array($tabName, $tmp)) {
//                                $logType[$json->f_log_name] = 1;
//                                $ret[] = array($json->f_log_name, $fileName);
//                                $type[] = $v ;
//
//                                if($json->f_log_name=='log_online_character_cnt'){
//                                    $json->f_log_name= 'log_onlineinfo' ;
//                                }
//                                if(in_array($tabName = 'bi_'.$json->f_log_name,$tabArr)){
//                                    echo 'in '.$json->f_log_name."<br/>"."<br/>"  ;
//
//                                }else{
//                                    echo '------ not in'.$json->f_log_name."<br/>"."<br/>"  ;
//                                }
//
//                            } else {
//                                $logType[$json->f_log_name]++;
//                            }
//                            } else {
////                            echo $v;
//                                echo "<br/>";
//                                echo "<br/>";
//                            }
//                        }
//                    }
//
//                }
//            }
//        foreach($ret as $v){
////            echo $v[1]."   :  " .$v[0]."<br/>";
//            echo $v[0] ;
//            echo "<br/>"; echo "<br/>";
//        }
////        foreach($type as $v){
//////            echo $v[1]."   :  " .$v[0]."<br/>";
////            echo $v ;
////            echo "<br/>"; echo "<br/>";
////        }
//        print_r($logType) ;
//            closedir($current_dir);
//        }


    function objeToArr($object)
    {
        $array = array();
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                if ($key == 'f_params') {
                    if ($value) {
                        $array = $array + $this->objeToArr($value);
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

    /**
     * @param $tmpData 原始数据 是个二维数据
     *
     *
     * @param $ret      一维数据 数据表要插入的数据字段值
     *
     */
    public function createSqlData($tmpData, &$lessArr, $tag, &$moreArr)
    {

        if (!isset($tmpData['f_log_name'])) {
            var_dump($tmpData);
            return;
        }
        $tabName = "bi_" . $tmpData['f_log_name'];
        $sql = "DESC $tabName ";
        $command = Yii::$app->db->createCommand($sql);
        $columns = $command->queryAll();
        $tpadArr = array('id', 'f_type', 'f_other');
        foreach ($columns as $v) {
            $colName = $v['Field'];
            if (isset($tmpData[$colName])) {
                $data[$colName] = $tmpData[$colName];
            }
        }

        Yii::$app->db->createCommand()->insert($tabName, $data)->execute();
        return;


//        Yii::$app->db->createCommand()->batchInsert(UserModel::$tabName(), ['user_id','username'], [
//            ['1','test1'],
//            ['2','test2'],
//            ['3','test3'],
//        ])->execute();
//
//


        foreach ($columns as $v) {
            $useColu[] = $v['Field'];
            if (!in_array($v['Field'], $tmpData)) {

                if (!in_array($v['Field'], $tpadArr) && !$tag) {
                    if (!in_array($v['Field'], $lessArr)) {
                        $lessArr[] = $v['Field'];
                        echo "缺少的字段:" . $tabName . ":" . $v['Field'] . "<br/><br/>";
                    }
                }
            }
        }


        foreach ($tmpData as $key => $val) {
            if ($key == 'f_log_name' || $key == 'f_params') continue;
            if (is_array($val)) {
                foreach ($val as $k1 => $v1) {
                    if ($key == 'f_log_name' || $key == 'f_params') continue;
                    if (!in_array($k1, $useColu)) {
                        if (!in_array($k1, $moreArr)) {
                            $moreArr[] = $k1;
                            echo $tabName . ":" . $k1 . "<br/><br/>";
                        }
                    }
                }
            } else {
                if (!in_array($key, $useColu)) {
                    if (!in_array($key, $moreArr)) {
                        $moreArr[] = $key;
                        echo '多出的字段:' . $tabName . ":" . $key . "<br/><br/>";
                    }

                }
            }
        }

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
