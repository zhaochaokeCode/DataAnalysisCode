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

    public function runSql($sql){
        echo $sql."<br>" ;
        $sql = iconv("utf-8", "gbk", $sql);
        $result =  $this->db->query($sql) ;
        print_r($result) ;
        return $result ;

    }

}