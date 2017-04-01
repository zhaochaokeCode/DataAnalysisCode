<?php

/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/3/17
 * Time: 下午6:07
 */
class mss
{
    public  $db ;
    public function __construct()

    {
        try {
            $hostname = "59.110.15.34";
            $port = 1433;
            $dbname = "taohua_log";
            $username = "sa";
            $pw = "Cthy@301*&";
            $this->db= new PDO ("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$pw");
        } catch
        (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
    }
    public  function getUserInfo(){

        $sql = "select DISTINCT(f_yunying_id) from log_character " ;
        echo $sql ;
        foreach($this->db->query($sql) as $row){
            echo $row['f_yunying_id'].",<br>"  ;
        }
    }


//    public function getToruist()
//    {
//        $deviceCode = $_POST['device_code'];
//        $userInfo = array('toruist_name' => $deviceCode);
//        if ($ret = $this->getInfo($userInfo)) {
//            $tmp = '$id';
//            $retId = $ret['_id']->$tmp;
//            $dataArr = array(
//                'user_id' => $retId,
//            );
//        } else {
//            $userInfo['regist_time'] = time();
//            $ret = $this->insertData($userInfo);
//            if ($ret) {
//                $tmp = '$id';
//                $retId = $ret['_id']->$tmp;
//                $dataArr = array(
//                    'user_id' => $retId,
//                );
//
//            }
//            $this->returnResu($dataArr);
//        }
//    }
//    public function transToruist(){
//        $deviceCode = $_POST['device_code'] ;
//        $userInfo = array('toruist_name'=>$deviceCode) ;
//        if($ret=$this->getInfo($userInfo)){
//            $userName = $_POST['phone_num'];
//            $password = $_POST['password'];
//            if($this->table->find(array('name'=>$userName))) $this->returnResu(false, 'phone already exit!');
//
//
//            $code = rand(1000,9999).time() ;
//            $dataArr = array(
//                "name"=>$userName,
//                "password"=>md5(md5($_POST['password'].$code)),
//                "code"=>$code,
//                "regist_time"=>time(),
//                "nick_name"=>''
//            );
//            $change = $this->insertData($dataArr) ;
//
//            if($change){
//                $tmp = '$id' ;
//                $retId = $change['_id']->$tmp ;
//                $dataArr =  array('phone_num' =>$_POST['phone_num'],
//                    'user_id' => $retId,
//                    'name'=>''
//                ) ;
//                $this->returnResu($dataArr);
//            }
//            $this->returnResu(false, 'no user');
//
//        }
//    }

        public function getTableName(){
        $sql = "select name from taohua_log.sys.tables where name like 'log%'" ;
        foreach($this->db->query($sql) as $row){
            $arr[] = $row['name'] ;
            echo  $row['name'] .',' ;
        }
        return $arr ;
    }

    public function getTabColumn($tab){
        $sql = "select name from syscolumns where id=object_id('$tab')" ;
        echo $sql ;
        $k=0 ;
        foreach($this->db->query($sql) as $row){
            $tmp = $row[0];
            echo $tmp.',' ;


            $k++ ;
        }
        echo $k ;
        die;
        $log_account =array('f_uid','f_dept','f_server_address_id','f_game_id','f_time','f_sid','f_yunying_id','f_account_id','f_phone_id','f_insert_time') ;
        return $$log_account ;


    }
    public function clear(){
        $tmp ='' ;
        $sql ="select 'truncate table '+name+' ;' from taohua_log.sys.tables where name like 'log%'";
        foreach($this->db->query($sql) as $row){
            $tmp .= $row[0] ;
        }
        $this->db->query($tmp)  ;


        $sql ="select 'truncate  table '+name+' ;' from taohua_internal_report.sys.tables where name like 'rpt%'";
        $tmp ='' ;
        foreach($this->db->query($sql) as $row){
            $tmp .= $row[0] ;
        }
        echo $tmp ;die;
        $this->db->query($tmp)  ;

    }

    public function runSql($sql){
        $sql = iconv("utf-8", "gbk", $sql);
        echo $sql."<br>" ;
        $result =  $this->db->query($sql) ;
        return $result ;

    }
    public function getData($type){



    }
}