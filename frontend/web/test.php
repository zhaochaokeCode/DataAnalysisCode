<?php

ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

header("Content-type: text/html; charset=utf-8");
try {
    $hostname = "59.110.15.34";
    $port = 1433;
    $dbname = "taohua_log";
    $username = "sa";
    $pw = "Cthy@301*&";
    $dbh = new PDO ("dblib:host=$hostname:$port;dbname=$dbname","$username","$pw");
} catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
}
var_dump($dbh) ;
die;



class mongdb{
    public $table ;

    public function __construct(){
        $conn  = new MongoClient('mongodb://root:cthy8566@dds-m5ea0bb2c4c1c5f41.mongodb.rds.aliyuncs.com:3717');
        $this->table  = $conn->user_info->user_detail ;
        $this->selectFun() ;
    }

    public function selectFun(){
        $data  = $_POST ;

        switch($data['action']){
            case 'regist' :
                $this->regist($data) ;
                break ;
            case 'login' :
                $this->login($data) ;
                break ;
        }

    }


    public function regist($data){

        $info = array('name'=>$data['name']) ;
        $userInfo = $this->table->findone($info) ;
        if($userInfo) $this->retdata(401,'fail, user already exit') ;

        $code = rand(1000,9000).time() ;
        $data2 = array(
            "name"=>$data['name'],
            "password"=>md5($data['password'].$code),
            "code"=>$code,
            "regist_time"=>$data['regist_time']
        ) ;
        if($data['email']){
            $data2['email']= $data['email'] ;
        }
        $result = $this->table->insert($data2) ;
        if($result['ok']==1){
            $tmp = '$id' ;
            $retId = $data2['_id']->$tmp ;
            $this->retdata(200,$retId) ;
        }else{
            $this->retdata(400,'fail') ;
        }


    }

    public function login($data){
        $info = array('name'=>$data['name']) ;
        $userInfo = $this->table->findone($info) ;

        if($userInfo){
            $sign = md5($data['password'].$userInfo['code']) ;
            if($sign==$userInfo['password']){
                $this->retdata(200,'success') ;
            }
        }
        $this->retdata(400,'fail') ;

    }


    public function retdata($code,$info){

        $data = array('code'=>$code,'id'=>$info) ;
        echo json_encode($data) ;
        die;
    }
}
//$newClass = new mongdb() ;




//$table->insert($user);
//$data = $table->find(array('name' => 'caleng')) ;

