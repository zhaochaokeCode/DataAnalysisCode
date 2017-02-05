<?php
$mouthName = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');
$numArr = range(1, 12);
$dateName = '日期';

return [
    'tabName' => array('install' => '新增用户报表', 'active' => '活跃玩家报表'),
    //报表的配置文件信息
    'tabConfig' => array(
        //-----游戏玩家-----
        "gamePlayer" => array(
            //----新增玩家----
            'character' => array(
                'tag' => array( //tag标签信息
                    array(//新增注册用户
                        'tagName'=>'新增注册用户',
                        'name' => array('新增注册用户'),
                        'dataName' => array('新增注册用户'),
                    ),
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '新增注册用户',),
                    )
                )

            ),
            //----付费玩家----
            'recharge' => array(
                'tag' => array( //tag标签信息
                    array(//新增注册用户
                        'tagName'=>'每日付费用户',//标签名称
                        'name' => array('每日充值金额'),
                        'dataName' => array('每日充值金额'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '充值金额',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----金币消耗玩家----
            'jinbi' => array(
                'tag' => array( //tag标签信息
                    array(//每日金币消耗
                        'tagName'=>'每日金币消耗',//标签名称
                        'name' => array('每日金币消耗'),
                        'dataName' => array('每日金币消耗'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '每日金币消耗',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----每日灵偶培养消耗掉的经验总值----
            'card_train' => array(
                'tag' => array( //tag标签信息
                    array(//每日灵偶培养消耗经验
                        'tagName'=>'每日灵偶培养消耗',//标签名称
                        'name' => array('name' => '灵偶培养消耗经验'),
                        'dataName' => array('灵偶培养消耗经验'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '灵偶培养消耗经验',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----每日技能功法消耗日志----
            'skill_up' => array(
                'tag' => array( //tag标签信息
                    array(//每日技能功法消耗日志
                        'tagName'=>'每日技能功法消耗日志',//标签名称
                        'name' => array('技能功法消耗数量'),
                        'dataName' => array('技能功法消数量'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '技能功法消耗数量',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----每日境界消耗真气日志----
            'jingjie_up' => array(
                'tag' => array( //tag标签信息
                    array(//每日技能功法消耗日志
                        'tagName'=>'每日技能功法消耗日志',//标签名称
                        'name' => array('境界消耗真气数量'),
                        'dataName' => array('境界消耗真气数量'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '境界消耗真气数量',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----每日击杀boss日志----
            'killboss' => array(
                'tag' => array( //tag标签信息
                    array(//每日击杀boss日志
                        'tagName'=>'每日击杀boss日志',//标签名称
                        'name' => array('击杀boss数量'),
                        'dataName' => array('击杀boss数量'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '击杀boss数量',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----每日获得元宝日志----
            'yuanbao' => array(
                'tag' => array( //tag标签信息
                    array(//每日获得元宝数量
                        'tagName'=>'每日获得元宝数量',//标签名称
                        'name' => array('获得元宝数量'),
                        'dataName' => array('获得元宝数量'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '获得元宝数量',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----每日登录人数----
            'login' => array(
                'tag' => array( //tag标签信息
                    array(//每日登录人数
                        'tagName'=>'每日登录人数',//标签名称
                        'name' => array('每日登录人数'),
                        'dataName' => array('每日登录人数'),
                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '每日登录人数',),
                        'dataname' => $mouthName,
                    )
                )

            ),
            //----留存----
            'retention' => array(
                'tag' => array( //tag标签信息
                    array(//三日留存
                        'tagName'=>'用户留存数据',//标签名称
                        'name' => array('三日留存','七日留存'),
                        'dataName' => array('每日登录人数'),
                    ),
//                    array(//三日留存
//                        'name' => array('每日登录人数'),
//                        'dataName' => array('每日登录人数'),
//                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '每日登录人数','三日留存'),
                        'dataname' => $mouthName,
                    ),
//                    array(//三日留存
//                        'name' => '每日登录人数',
//                        'dataName' => array('每日登录人数'),
//                    )
                )

            ),

        )
    )
//            //----活跃玩家----
//            'tmp'=>array(
//                'tag' => array( //tag标签信息
//                    array(//新增激活和账户
//                        'name' => '新增活跃',
//                        'categories' => $mouthName,
//                        'dataName' => array('设备激活1', '新增玩家1'),
//                    ),
//                    array(//玩家转化
//                        'name' => '测试活跃',
//                        'categories' => $numArr,
//                        'dataName' => array('玩家转化'),
//                    ),
//                    array(//玩家转化
//                        'name' => '测试数据',
//                        'categories' => $numArr,
//                        'dataName' => array('测试数据'),
//                    )
//                ),
//                'tab_all'=>array(
//                    array(
//                        'thred'=>array($dateName,'设备激活', '新增玩家') ,
//                        'dataname'=>$mouthName,
//                    ),
//                    array(
//                        'thred'=>array($dateName,'玩家转化',) ,
//                        'dataname'=>$mouthName,
//                    ),
//                    array(
//                        'thred'=>array($dateName,'测试数据',) ,
//                        'dataname'=>$mouthName,
//                    ),
//                )
//
//            ),


];
