<?php

namespace frontend\controllers;


use Yii ;
use yii\web\Controller;


class PayController extends Controller
{
    private $fileCharset = "UTF-8";
    public $postCharset = "UTF-8";

    /**
     *  默认的是 阿里支付 不要为问什么
     * 因为我喜欢阿里 哈哈
     *
     *
     * order_id 游戏生成
     * pr
     *
     *
     *
     *
     */
    public function init()
    {
        $this->checkSign() ;
    }



    public function actionIndex()
    {
        $app_id = "2017011205020547" ;
        if($this->saveOrder($_POST,1)) {
            $parameter = array(
                "app_id" => $app_id,
                "biz_content" => json_encode(array(
                    "timeout_express" => "30m",
                    "product_code" => "QUICK_MSECURITY_PAY",
                    "total_amount" => $_POST['total_amount'],
                    "subject" => $_POST['product_name'],
                    "out_trade_no" => $_POST['order_id']
                )),
                "charset" => "utf-8",
                "format" => "json",
                "method" => "alipay.trade.app.pay",
                "notify_url" => "http://116.62.100.98/pay/recall",
                "sign_type" => "RSA2",
                "timestamp" => $_POST['time'],
                "version" => 1.0,

            );
            echo json_encode(array('code' => 200, 'data' => $this->createUrlStr($parameter), 'message' => 'success'));
        }
    }

    /**
     * 阿里的回调接口
     */
    public function actionRecall(){
        if(file_put_contents('/tmp/data.txt',json_encode($_POST)."-----".date("Y-m-d H:i:s",time()."\n"),FILE_APPEND)) {
            echo 'success';
        }else{
            echo 'fail' ;
        }

    }




    function createUrlStr($parameter){
        $parameter['sign'] = $this->sign($this->getSignContent($parameter));
        $parameter = $this->encodeStr($parameter) ;
        return $this->getSignContent($parameter) ;
    }

    function getSignContent($params)
    {
        ksort($params);

        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

// 转换成目标字符集
                $v = $this->characet($v, $this->postCharset);

                if ($i == 0) {
                    $stringToBeSigned .= $k. "=" .$v;
                } else {
                    $stringToBeSigned .= "&" .$k. "=" .$v;
                }

                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    function checkEmpty($value)
    {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }

    function characet($data, $targetCharset)
    {

        if (!empty($data)) {
            $fileType = $this->fileCharset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }


    public function sign($data)
    {
        $priKey = "MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQC8JpFvf8A2unLyRQbFCM4ghhcOo/NE4p73CMgN3/jQ/00znwzfjw2tjwk+/IpLXc9vH/z5VIEFe7JHFJ2mlnlzO5tgscqlQGrxK6pHHRUgolwDuCG0yDrqH8X6jTkvra2oa9DrGmw7biRNvXYs61oVnPNmCcKPLonCX9CUDawr8rLmh+RXZBQlf2DjbGrbA3Ro7YQJgptWmgtiJF9kl8vlstKuVadnFSALXi/Bucyng8n8+OBHnH17hA4ch3tU/qqtfT61eLZYes2jx0ZTiP1mebavtDBrjzBeKldBI+XG33shJGghgZC5QmViN+GuynIckg2TjfzNU2CUK52Ij3ebAgMBAAECggEABcyahvlFD2rHyDfgcYpH8DCx3T2obeMeSzb2E5dnr+luk7y/RNS/8y2Jd2uJR7Foh2BRB85W+7hIUnCMO2o/7BFWRLC2Mkm+Ahj6cp6u3AalF2hBgbT6O+Um0QYxUQrlY1+PXO+/jkVi0RKZ5eCLMkdYKTj7yjYBAQC7CRUyzVfsAx0J3s/bq66hh7QSn0/Igs8S1u7iimYVpBaqyPTd05xBgvlGu3znjoLiu5IvCMvXeWin0RFUXBF575RVPNuuU0kbPqii05h8NK+ncOTG36DPZeA0fbUv9tzNQMGtorwXjDeWN7v2GtmhyZQJdxu2/iM2j4/jjuTqD9TVgeWzIQKBgQD//Pc2jpXQCOC+djQo24NNyEIdNQi0clq1S0j3aiWbnyNqYqGwpi79tKHcLg41uz85AO+mPpqzt4ed0EWXq81DmFKLPi+/5Fv92n3AtqA+LqjHcSOSd/wdFDq93l4HHN3f+2wW+/7/YoDmBuHEQyMWnOwOR4gwpuq0sj3CsjKxpwKBgQC8KMxfOqVloKMLEMFXXf3kZesQ54Vf4qW7MzTEy1h9RMaFSdQw9CUdV/JpEEJTH5w7J52aIjVQbpbMbOubhprynp3151Tw2RY4EMg9DWuQh3HBR71vEkjZ/9O0DkA+a/EYUe7BxWyJYO2FCHm4pk7inUcc2qqpU3dAUZgDjXcA7QKBgQDxZDIamEpdaoHEGOMGxDkFWBpAQIp83nj7DIs6BDaCkYZsA6ZFVfBp/bPEVQnBUVlE/8T9F3v6jM6t2oBFjhR58WGlPHb6lPTKZQbAe3aQLJ+rstzAebScFz9tXAt+2ZHAbO54nhjP6qtyPnsW/9hOsptGu92JQ12AF7R1rGRxcQKBgQCx/XoO32BUeZeiQRBUADLLWun5jLlrUfBq3G6fdqhXn7aXoZZbVKjDUE2cu2eyUCWvA7OfeZqrYmG+MY7TCYsL1aYhVtrQFttg3+c7cbV9+9JM/vsg1dAagFmYax60rdFcqyzLGmGotwsYnELgvFnFHviFQAjOsokNS+IcAjc/pQKBgQCKMY43w1jU+eXt1jujal84QpbT8VgHRPMU4KZfy2dthvANIxxSUa67FE8sEF6v8XWv2ohyy4JkdlTmfIrpLr0SwLd/ZaoEiKfcARngaAMt2r3LOaFCbpzwh+nTGQwWpTDUyyb7Q4VP9ZDamPRnh1HzofZSY53s/j5zkghGA0uLtg==";
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        openssl_sign($data, $sign, $res,OPENSSL_ALGO_SHA256);
        $sign = base64_encode($sign);
        return $sign;
    }
    public function encodeStr($data){
        foreach($data as $k=>$v){
            $data[$k]=urlencode($v);
        }
        return $data ;
    }


    /**
     * 微信支付
     */
    public function actionWxpay(){
        $wxpay_config = array(
            'app_id' => 'wxd9d911dea9726475',
            'app_secret' => 'd8ff100ddbfa59b1530df883890b411a',
            'mch_id' => '1434267502',
            'partner_id' => 'mGUPhEEyKHafb2CRMQ4jkg9Pz6GWBqqK',
            'notify_url' => 'http://116.62.100.98/pay/wxre'
        );
         //var_dump($wxpay_config);

        $APP_ID = $wxpay_config['app_id'];            //APPID
        $APP_SECRET = $wxpay_config['app_secret'];    //appsecret
        $MCH_ID=$wxpay_config['mch_id'];
        $PARTNER_ID = $wxpay_config['partner_id'];
        $NOTIFY_URL = $wxpay_config['notify_url'];



        //STEP 1. 构造一个订单。
        $order=array(
            "body" => 'test data',
            "appid" => $APP_ID,
            "device_info" => "APP-001",
            "mch_id" => $MCH_ID,
            "nonce_str" => mt_rand(),
            "notify_url" => $NOTIFY_URL,
            "out_trade_no" =>'2017031'.time() ,
            "spbill_create_ip" => "210.12.129.178",//$this->input->ip_address(),
            "total_fee" => intval(1),//注意：前方有坑！！！最小单位是分，跟支付宝不一样。1表示1分钱。只能是整形。
            "trade_type" => "APP"
        );
        ksort($order);

        //STEP 2. 签名
        $sign="";
        foreach ($order as $key => $value) {
            if($value&&$key!="sign"&&$key!="key"){
                $sign.=$key."=".$value."&";
            }
        }
        $sign.="key=".$PARTNER_ID;
        $sign=strtoupper(md5($sign));//echo $sign.'<br/>';exit;

        //STEP 3. 请求服务器
        $xml="<xml>\n";
        foreach ($order as $key => $value) {
            $xml.="<".$key.">".$value."</".$key.">\n";
        }
        $xml.="<sign>".$sign."</sign>\n";
        $xml.="</xml>";
        //echo $sign.'<br/>';
        $opts = array(
            'http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: text/xml',
                    'content' => $xml
                ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            )
        );
        $context  = stream_context_create($opts);
        $result = file_get_contents('https://api.mch.weixin.qq.com/pay/unifiedorder', false, $context);

        $result = simplexml_load_string($result,null, LIBXML_NOCDATA);

        //
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $prepay=array(
                "noncestr"=>"".$result->nonce_str,
                "prepayid"=>"".$result->prepay_id,//上一步请求微信服务器得到nonce_str和prepay_id参数。
                "appid"=>$APP_ID,
                "package"=>"Sign=WXPay",
                "partnerid"=>$MCH_ID,
                "timestamp"=>"".time(),
                "sign"=>""
            );
            ksort($prepay);
            $sign="";
            foreach ($prepay as $key => $value) {
                if($value&&$key!="sign"&&$key!="key"){
                    $sign.=$key."=".$value."&";
                }
            }
            $sign.="key=".$PARTNER_ID;
            $sign=strtoupper(md5($sign));
            $prepay['sign'] = $sign;
            $prepay['success'] = true;
        } else {
            $prepay=array(
                "success" => false,
                "noncestr"=>"",
                "prepayid"=>"",
                "appid"=>$APP_ID,
                "package"=>"Sign=WXPay",
                "partnerid"=>$MCH_ID,
                "timestamp"=>"".time(),
                "sign"=>"",
                "return_msg"=>$result->return_msg
            );
        }
        echo json_encode(array('data'=>$prepay,'code'=>'200','message'=>'true')) ;

    }

    /**
     * 微信回调
     */
    public function actionWxre(){

        $fileContent = file_get_contents("php://input");

        if(file_put_contents('/tmp/data.txt',$fileContent."-----".date("Y-m-d H:i:s",time()."\n"),FILE_APPEND)) {
            echo 'success';
        }else{
            echo 'fail' ;
        }
    }
    public function checkSign(){
        $str = '' ;
        foreach($_POST as $k=>$v){
            if($k!='sign'){
                $str .= $k.$v ;
            }

        }
        $tmp = $str.'ASD23%*!KK4@8MwdWddOc' ;

        $md5Str = md5($tmp) ;
//        echo $tmp."-----".$md5Str.'-------'.$_POST['sign'] ;

        if($md5Str != $_POST['sign']){
            $data = array('code'=>400,
                'message'=>'sign error',
                'data'=>array()
            ) ;
            echo json_encode($data) ;die;

        }else{
            $data = array('code'=>200,
                'message'=>'success',
                'data'=>array()
            ) ;
//            echo json_encode($data) ;die;
        }


    }
    private function saveOrder($data,$type){

        $data2 = array(
            "f_game_id"=>$data['game_id'],
            "f_game_name"=>urldecode($data['game_name']),
            "f_order_id"=>$data['order_id'],
            "f_pay_type"=>$type,
            "f_product_id"=>$data['product_id'],
            "f_product_name"=>urldecode($data['product_name']),
            "f_role_id"=>$data['role_id'],
            "f_role_name"=>urldecode($data['role_name']),
            "f_server_id"=>urldecode($data['server_id']),
            "f_server_name"=>urldecode($data['server_name']),
            "f_time"=>$data['time'],
            "f_yunying_id"=>$data['yunying_id'],
            "f_sn_id"=>$data['channel'],
            "f_total_amount"=>$data['total_amount'],
            "f_extension"=>urldecode($data['extension']),
            "f_device"=>$data['device'],
            "f_os"=>$data['os'],
            "f_status"=>0
        ) ;
//
       return   Yii::$app->db2->createCommand()->insert("create_order_info",$data2)->execute() ;
    }

}

