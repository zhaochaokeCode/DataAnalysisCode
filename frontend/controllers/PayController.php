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
//    public function init()
//    {
//        $this->checkSign() ;
//    }



    public function actionIndex()
    {
        $this->checkSign() ;
        $app_id = "2017011205020547" ;
        $time =time() ;
        if($this->saveOrder($_POST,1,$time)) {
            $parameter = array(
                "app_id" => $app_id,
                "biz_content" => json_encode(array(
                    "timeout_express" => "30m",
                    "product_code" => "QUICK_MSECURITY_PAY",
                    "total_amount" => $_POST['total_amount'],
                    "subject" =>urldecode($_POST['game_name'].' '.$_POST['product_name']),
                    "out_trade_no" =>$_POST['order_id']
                )),
                "charset" => "utf-8",
                "format" => "json",
                "method" => "alipay.trade.app.pay",
                "notify_url" => "http://116.62.100.98/pay/recall",
                "sign_type" => "RSA2",
                "timestamp" => date("Y-m-d H:i:s",$time),
                "version" => 1.0,

            );
            echo json_encode(array('code' => 200, 'data' => $this->createUrlStr($parameter), 'message' => 'success'));
        }
    }

    /**
     * 阿里的回调接口
     */
    public function actionRecall(){
//        $_POST =$this->objeToArr(json_decode('{
//    "total_amount": "0.01",
//    "buyer_id": "2088102757673262",
//    "trade_no": "2017022121001004260296548514",
//    "notify_time": "2017-02-21 16:17:54",
//    "subject": "三生三世十里桃花 元宝",
//    "sign_type": "RSA2",
//    "buyer_logon_id": "mot***@163.com",
//    "auth_app_id": "2017011205020547",
//    "charset": "utf-8",
//    "notify_type": "trade_status_sync",
//    "invoice_amount": "0.01",
//    "out_trade_no": "BWD1487665053",
//    "trade_status": "TRADE_SUCCESS",
//    "gmt_payment": "2017-02-21 16:17:53",
//    "version": "1.0",
//    "point_amount": "0.00",
//    "gmt_create": "2017-02-21 16:17:53",
//    "buyer_pay_amount": "0.01",
//    "receipt_amount": "0.01",
//    "app_id": "2017011205020547",
//    "seller_id": "2088521621890572",
//    "notify_id": "d425186f9ff795eb01bad490a4bf0bfi0a",
//    "seller_email": "chuntianhuyu@baiwen100.com"
//}')) ;

        $this->saveAliInfo($_POST) ;
        $isSign = $this->getSignVeryfy($_POST, $_POST["sign"]);

        /**
         * 如过校验成功
         */
        if($isSign){
            echo 'success' ;
            $order_id       = $_POST['out_trade_no'] ;
            $total_money    = $_POST['total_amount'];
            $time           = $_POST['notify_time'];
            $this->saveRecallData($order_id,$total_money,$time);

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
        $time = time() ;
        if($this->saveOrder($_POST,2,$time)) {

            /**
             * --------根据gameid获取
             */
            $app_id = 'wxd9d911dea9726475' ;
            $app_secret = 'd8ff100ddbfa59b1530df883890b411a' ; //私钥
            $mch_id = '1434267502' ;
            $partner_id = 'mGUPhEEyKHafb2CRMQ4jkg9Pz6GWBqqK' ; //api秘钥

            //-------------------------------------
            $notify_url = 'http://116.62.100.98/pay/wxre' ;
            $wxpay_config = array(
                'app_id' => $app_id ,
                'app_secret' => $app_secret,
                'mch_id' => $mch_id, //商户id
                'partner_id' => $partner_id,
                'notify_url' => $notify_url
            );
            //var_dump($wxpay_config);

            $APP_ID = $wxpay_config['app_id'];            //APPID
            $APP_SECRET = $wxpay_config['app_secret'];    //appsecret
            $MCH_ID = $wxpay_config['mch_id'];
            $PARTNER_ID = $wxpay_config['partner_id'];
            $NOTIFY_URL = $wxpay_config['notify_url'];


            //STEP 1. 构造一个订单。
            $order = array(
                "body" =>urldecode($_POST['game_name']).' '.urldecode($_POST['product_name']),
                "appid" => $APP_ID,
                "device_info" => $_POST['device'],
                "mch_id" => $MCH_ID,
                "nonce_str" => mt_rand(1,1000000),
                "notify_url" => $NOTIFY_URL,
                "out_trade_no" => $_POST['order_id'],
                "spbill_create_ip" => "101.37.18.43",//$this->input->ip_address(),
                "total_fee" => $_POST['total_amount'],//注意：前方有坑！！！最小单位是分，跟支付宝不一样。1表示1分钱。只能是整形。
                "trade_type" => "APP"
            );
            ksort($order);

            //STEP 2. 签名
            $sign = "";
            foreach ($order as $key => $value) {
                if ($value && $key != "sign" && $key != "key") {
                    $sign .= $key . "=" . $value . "&";
                }
            }
            $sign .= "key=" . $PARTNER_ID;
            $sign = strtoupper(md5($sign));//echo $sign.'<br/>';exit;

            //STEP 3. 请求服务器
            $xml = "<xml>\n";
            foreach ($order as $key => $value) {
                $xml .= "<" . $key . ">" . $value . "</" . $key . ">\n";
            }
            $xml .= "<sign>" . $sign . "</sign>\n";
            $xml .= "</xml>";
            //echo $sign.'<br/>';
            $opts = array(
                'http' =>
                    array(
                        'method' => 'POST',
                        'header' => 'Content-type: text/xml',
                        'content' => $xml
                    ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            );

            $context = stream_context_create($opts);
            $result = file_get_contents('https://api.mch.weixin.qq.com/pay/unifiedorder', false, $context);

            $result = simplexml_load_string($result, null, LIBXML_NOCDATA);
            //
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
                $prepay = array(
                    "noncestr" => "" . $result->nonce_str,
                    "prepayid" => "" . $result->prepay_id,//上一步请求微信服务器得到nonce_str和prepay_id参数。
                    "appid" => $APP_ID,
                    "package" => "Sign=WXPay",
                    "partnerid" => $MCH_ID,
                    "timestamp" => $time,
                    "sign" => ""
                );
                ksort($prepay);
                $sign = "";
                foreach ($prepay as $key => $value) {
                    if ($value && $key != "sign" && $key != "key") {
                        $sign .= $key . "=" . $value . "&";
                    }
                }
                $sign .= "key=" . $PARTNER_ID;
                $sign = strtoupper(md5($sign));
                $prepay['sign'] = $sign;
                $prepay['success'] = true;
            } else {
                $prepay = array(
                    "success" => false,
                    "noncestr" => "",
                    "prepayid" => "",
                    "appid" => $APP_ID,
                    "package" => "Sign=WXPay",
                    "partnerid" => $MCH_ID,
                    "timestamp" => $time ,
                    "sign" => "",
                    "return_msg" => $result->return_msg
                );
            }
            echo json_encode(array('data' => $prepay, 'code' => '200', 'message' => 'true'));
        }

    }

    /**
     * 微信回调
     */
    public function actionWxre(){

        $fileContent = file_get_contents("php://input");
        $this->saveToFile('wxRellData:'.$fileContent) ;

        $array_data = json_decode(json_encode(simplexml_load_string($fileContent, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $this->saveRecallData($array_data['out_trade_no'],$array_data['out_trade_no'],$array_data['time_end']) ;
    }
    public function checkSign($data=false){
        $checkData = $data?$data:$_POST ;
        $str = '' ;
        foreach($checkData as $k=>$v){
            if($k!='sign'){
                $str .= $k.$v ;
            }

        }
        $tmp = $str.'ASD23%*!KK4@8MwdWddOc' ;

        $md5Str = md5($tmp) ;
//        echo $tmp."-----".$md5Str.'-------'.$_POST['sign'] ;

        if($md5Str != $checkData['sign']){
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
    private function saveOrder($data,$type,$time){

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
            "f_time"=>$time,
            "f_yunying_id"=>$data['yunying_id'],
            "f_sn_id"=>$data['channel'],
            "f_total_amount"=>$data['total_amount'],
            "f_extension"=>urldecode($data['extension']),
            "f_device"=>$data['device'],
            "f_os"=>$data['os'],
            "f_status"=>0
        ) ;
        return $this->saveToFile(implode(',',$data2)) ;
//        return   Yii::$app->db2->createCommand()->insert("create_order_info",$data2)->execute() ;
    }
    public function objeToArr($object)
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

        return $array;

    }
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    function getSignVeryfy($para_temp, $sign) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = $this->paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = $this->argSort($para_filter);


        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->createLinkstring($para_sort);

        $alipay_public_key = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAs+Vie7KknXGSk9NmnnAY6SK9EOQWs8CorI7lGE7XBHOCSQnTJ566rEdpU5BsnTs2qzKjZhohQsnYsvfGiR1gHO4OB4hs/Dir9DG3+7uB9ij3mjf4lHq2CxNr4ddG6XDfC3Tjr890go+XMkS00DoeF3SNslY25vj9JTzJ8L8kGBBjS34AvsV+CWhuy5S56YRaEjahgYL49eijycRxXGhaq+bOqsYpAH6ZJLN4CnRycpCNoMBiNNVapFgm9iffRD4YoOD1US5xuj+Ya/u6HKv2WNhyDkL8fRJI6Xr5w7TQsqIDLbGyxt10MvsDQhy9MNaaOYUOeesD+O/UhxsHjGGqIQIDAQAB' ;
        $alipay_public_key='-----BEGIN PUBLIC KEY-----'.PHP_EOL.wordwrap($alipay_public_key, 64, "\n", true) .PHP_EOL.'-----END PUBLIC KEY-----';

        $res=openssl_get_publickey($alipay_public_key);
        if($res)
        {
            $result =(bool)openssl_verify($prestr, base64_decode($sign), $res,OPENSSL_ALGO_SHA256);
        }
        else {
            echo "您的支付宝公钥格式不正确!"."<br/>"."The format of your alipay_public_key is incorrect!";
            exit();
        }
        openssl_free_key($res);
        return $result ;
    }


    function paraFilter($para) {
        $para_filter = array();
        while (list ($key, $val) = each ($para)) {
            if($key == "sign" || $key == "sign_type")continue;
            else	$para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }
    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    function createLinkstring($para){
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

        return $arg;
    }

    public function saveAliInfo($data){

//        $sql = "DESC ali_repay_info" ;
//        $command = Yii::$app->db2->createCommand($sql);
//        $resultAll = $command->queryAll();
//        foreach($resultAll as $v){
//            $Field = $v['Field'] ;
//            if($Field!='id'){
//                $newData[$Field]= $_POST[$Field] ;
//            }
//        }
        $str = '' ;
        foreach($_POST as $k=>$v){
            $str .= "$k=$v" ;
        }

        $this->saveToFile('aliserviceInfo:'.$str) ;
//        $command = Yii::$app->db2->createCommand()->insert('ali_repay_info',$newData)->execute();
    }



    public function saveRecallData($order_id,$total_money,$time){
        $key = "EoL32&JSUVt30JHir6v48sk!" ;
        $data = array("order_id"=>$order_id,
            "total_money"=>$total_money,
            "time"=>$time,
            "other"=>"1"
        );
        $recallUrl = "http://114.55.249.122:40200/notify/002050000/" ;
        $condition = $this->getSignContent($data) ;
        $sign = md5($condition.$key);
        $url =$recallUrl.$condition."sign=$sign" ;

        $this->saveToFile('recallGame:'.$url) ;

        $data = file_get_contents($condition ) ;
        if(is_array($data)){
            $data = implode(',',$data) ;
        }

        $this->saveToFile('gameSerData:'.$data) ;

    }

    public function saveToFile($str){
        $time = date("Y-m-d H:i:s") ;
        return file_put_contents('/tmp/data.txt',$str."-------".$time."\n\n",FILE_APPEND) ;
    }

}

