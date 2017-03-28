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


    /**
     * @param $table
     * @param $num    sqlserev的死bug 无法查询到为空的数据列,补齐所缺失的列
     *
     *
     * @return array
     */
    public function getData($table,$num=0,$where){
        $dataArr =array() ;
        $page=$_GET['page']?$_GET['page']:1 ;
        $tableName = "rpt_inter_$table" ;

        //---limmt数据取值范围----
        if($page==1){
            $start = 0 ;
            $end = 11 ;
        }else{
            $start = ($page-1)*10 ;
            $end   = ($page-1)*10+11 ;
        }

        //limit语句
        $sql ="select top 10 * from ( select id=row_number() over(order by f_time desc ), * from $tableName $where )b
              where id>$start and id<$end order by id asc " ;
        //----- 查询
        $dataArr = $this->db->query($sql) ;

        //--重新拼装数据------
        foreach($dataArr as $k=>$v){
            $tmpArr = array() ;
            $leng = count($v)/2 ;
            for($i=1;$i<$leng;$i++){
                if($i==1){
                    $tdate = str_replace("12:00:00:AM",'',$v[$i]) ;
                    $tmp = explode(" ",$tdate) ;
                    if($tmp[0]=='Mar') $mouth = 3 ;

                    $v[$i]  = $tmp[2]."-".$mouth."-".$tmp[1] ;
                }
                $v[$i]=$v[$i]==null?0:$v[$i] ;
                $tmpArr[] = $v[$i] ;

            }
            for($k=0;$k<=$num-$leng;$k++){
                $tmpArr[] = 0;
            }
            //---因为sqlservr的原因,无法查找到为空的数据,所以根据首行的宽度
            //---补齐所缺少的字段

            $newData[] = $tmpArr ;


        }
        return $newData ;

    }
    public function getDataNum($table,$where){
        $dataArr =array() ;
        $tableName = "rpt_inter_$table" ;

        $sql = "select count(*) from $tableName $where " ;
//        echo $sql ;die;
        $dataArr = $this->db->query($sql) ;
        foreach($dataArr as $v){
            $num = $v[0] ;
        }
        return $num ;
    }

}