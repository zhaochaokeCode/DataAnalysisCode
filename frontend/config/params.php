<?php
$mouthName=array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月') ;
$numArr  = range(1,12) ;

return [
    //报表的配置文件信息
    'tabConfig'=>array(
        //-----游戏玩家-----
        "gamePlayer"=>array(
            //----新增玩家----
            'install'=>array(
                array(//新增激活和账户
                    'name'=>'新增激活和账户',
                    'categories'=>$mouthName,
                    'dataName'=>array('设备激活','新增玩家'),
                ),
                array(//玩家转化
                    'name'=>'玩家转化',
                    'categories'=>$numArr,
                    'dataName'=>array('玩家转化'),
                )

            ),

            //----活跃玩家----
            'active'=>'',

            //----玩家留存----
            'remain'=>'',

            //----付费转化----
            'translate'=>'',

            //----玩家刘谁
            'runoff'=>'',




        ),






    ),






];
