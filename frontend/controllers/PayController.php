<?php

namespace frontend\controllers;


use Yii ;
use yii\web\Controller;


class PayController extends Controller
{
    private $fileCharset = "UTF-8";
    public $postCharset = "UTF-8";
    public function actionIndex()
    {
        $parameter = array(
            "app_id" => "2017011205020547",
            "biz_content" => json_encode(array(
                "timeout_express" => "30m",
                "seller_id" => "",
                "product_code" => "QUICK_MSECURITY_PAY",
                "total_amount" => "0.01",
                "subject" => 1,
                "body" => "我是测试数据",
                "out_trade_no" => "20170114000001"
            )),
            "charset" => "utf-8",
            "format" => "json",
            "method" => "alipay.trade.app.pay",
            "notify_url" => "http://116.62.100.98/pay/recall",
            "sign_type" => "RSA2",
            "timestamp" => date("Y-m-d H:i:s", time()),
            "version" => 1.0,

        );
        echo $this->createUrlStr($parameter) ;
    }

    public function actionRecall(){
       echo file_put_contents('/tmp/data.txt',json_encode($_POST)."\n".date("Y-m-d H:i:s",time()),FILE_APPEND) ;
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
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
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




}

