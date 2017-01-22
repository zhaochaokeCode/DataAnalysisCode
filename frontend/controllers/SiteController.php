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
                        $tmp = array_keys($logType);
                        if (isset($json->f_log_name)) {
                            if (!in_array($json->f_log_name, $tmp)) {
                                $logType[$json->f_log_name] = 1;
                                $ret[] = array($v, $fileName);
                            } else {
                                $logType[$json->f_log_name]++;
                            }
                        } else {
                            echo $v;
                            echo "<br/>";
                            echo "<br/>";
                        }
                    }
                }


            }
        }
        foreach($ret as $v){
            echo $v[1]."   :  " .$v[0]."<br/>";
            echo "<br/>"; echo "<br/>";
        }

        closedir($current_dir);
    }


}
