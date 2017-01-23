<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
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

        $path = Yii::$app->params['logPath'];
        $current_dir = opendir($path);
        $logType = array();
        $ret = array();


        //获取mysql的表名
        $sql= "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'data_analysis'";
        $command=Yii::$app->db->createCommand($sql);
        $posts = $command->queryAll();
        foreach($posts as $v){
            $tabArr[] =$v['TABLE_NAME'] ;
        }


        while (($file = readdir($current_dir)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            } else if (is_dir($file)) {    //如果是目录,进行递归
            } else {
                $fileName = $path . '/' . $file;
                $cont = file_get_contents($fileName);
                $datas = explode("\n", $cont);

                foreach ($datas as $v) {
                    if ($json = json_decode($v)) {
                        $tmpData = $this->objeToArr($json) ;
                        $sqlData = $this->createSqlData($tmpData);

                        continue ;
                        $tmp = array_keys($logType);

                        if (($name=$useData['f_log_name'])) {
                            if($name=='log_online_character_cnt') $name='log_onlineinfo';
                            $tabName ='bi_'.$name ;



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
                        } else {
//                            echo $v;
                            echo "<br/>";
                            echo "<br/>";
                        }
                    }
                }

            }
        }
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
        closedir($current_dir);
    }

    public function createTab($object,$tabName){
        //对象先转换成为数据
        $data = $this->objeToArr($object) ;
        var_dump($data) ;die;

    }

    public function objeToArr($object){
        $array=array();
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                if(is_object($value)){
                    if($value) {
                        $value = $this->objeToArr($value);
                    }
                }
                $array[$key] = $value;

            }
        }
        else {

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
    public function createSqlData($tmpData){
        if(!isset($tmpData['f_log_name'])){
            var_dump($tmpData) ;return;
        }
        $tabName = $tmpData['f_log_name'];

        $sql = "DESC bi_$tabName " ;
        $command=Yii::$app->db->createCommand($sql);
        $columns = $command->queryAll();
        foreach($columns as $v){
            $useColu[] =$v['Field'] ;
        }

        foreach($tmpData as $key=>$val){
            if($key=='f_log_name'||$key=='f_params') continue ;
            if(is_array($val)){
                foreach($val as $k1=> $v1){
                    if($key=='f_log_name'||$key=='f_params') continue ;
                    if(!in_array($k1,$useColu)){

                        echo $tabName.":".$k1."<br/><br/>" ;
                    }
                }
            }else{
                if(!in_array($key,$useColu)){
                    echo  $tabName.":".$key."<br/><br/>" ;
                }
            }
        }

    }




}
