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
//        echo 123;
//        if (!isset($_GET['create'])) ;  return;

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
            $fileName = $logPath . $v;
            $cont = file_get_contents($fileName);

            $datas = explode("\n", $cont);
            $lessArr = array();
            foreach ($datas as $v) {
                if ($json = json_decode($v)) {
                    $tmpData = $this->objeToArr($json);
                    $tag = true;
                    if (isset($json->f_params)) {
                        $tmp2 = array();
                        foreach ($json->f_params as $k => $v) {
                            $tmp2[$k] = $v;
                        }
                        if (!$tmp2) $tag = false;
                        $tmp1 = $this->objeToArr($json->f_params);
                        if (count($tmp1) > 5) {
                        }

                    }
                    $moreArr = array();
                    $sqlData = $this->createSqlData($tmpData, $lessArr, $tag, $moreArr);
                }
            }
        }
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
                    if ($colName == "f_time") {
                        $time = $tmpData[$colName];
                        if (stristr($time, '.')) {
                            $tmpArr = explode('.', $time);
                            $tmpData[$colName] = strtotime($tmpArr[0]);
                        }
                        if (strlen($tmpData[$colName]) > 11) {
                            echo $tmpData[$colName] . "<br/><br/>";
                            continue;
                        }
                    }

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


    }
