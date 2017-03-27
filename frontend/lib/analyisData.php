<?php

/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/3/17
 * Time: 下午6:07
 *
 * 数据分析查询数据接口
 */
class analyisData
{
    public  $db ;
    public function __construct()
    {
        try {
            $hostname = "59.110.15.34";
            $port = 1433;
            $dbname = "taohua_internal_report";
            $username = "sa";
            $pw = "Cthy@301*&";
            $this->db= new PDO ("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$pw");
        } catch
        (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
    }
    public function getData($table){
        $dataArr =array() ;
        $tableName = "rpt_inter_$table" ;

        $sql = "SELECT * FROM $tableName WHERE f_dept=-1
                AND f_sid=-1 " ;
        $dataArr = $this->db->query($sql) ;
        foreach($dataArr as $k=>$v){
            $tmpArr = array() ;
            $leng = count($v)/2 ;
            for($i=0;$i<$leng;$i++){
                if($i==0){
                    $tdate = str_replace("12:00:00:AM",'',$v[$i]) ;
                    $tmp = explode(" ",$tdate) ;
                    $v[$i]  = $tmp[2]."-".$tmp[0]."-".$tmp[1] ;
                }
                $v[$i]=$v[$i]==null?0:$v[$i] ;

                $tmpArr[] = $v[$i] ;
            }
            $newData[] = $tmpArr ;
        }
        return $newData ;

    }

}