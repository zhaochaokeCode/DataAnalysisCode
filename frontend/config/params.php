<?php
$mouthName = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');
$numArr = range(1, 12);
$dateName = '日期';
/* *
* 配置文件
* 版本：3.5
* 日期：2016-06-25
* 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
* 2、更换浏览器或电脑，重新登录查询。
 */

//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['partner']='2088521621890572';
//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
$alipay_config['seller_id']	= $alipay_config['partner'];


//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$alipay_config['private_key']	= 'MIICWwIBAAKBgQDOer3f+Q9YFBKf5rwC++MQrJA4L4YkntdCqAamhPEVqTFwER1xAJ/DoSToIWLmDq5WN03sAwUHI9VzgfRbEzaiLNyvbJNu+MAHabk91W55sc8RgGDfEOXRAr0yMv+5Luv+3EXUyWOogpB6PM9AhpfKxBy+syg2D4CeZBYV4zuxcwIDAQABAoGAD7CcBQzz8Yl08Nmjp8ZkNrwmKV7THq1DRjlmZ/jqKO82ZoGmbxPREBiKqWkADuNGtB53uVtxYl2CtshFPTZ0jDNMbw2p9PWif3jUnPYj3q6Vkri+ojwfg8LrED2I9+oXta9Oj+Y2Ieill0IlLF4/LW8p0J/eK1I4tRUuyaUvreECQQDvRa7C5Q0noRC4uZ5/8W2M7z+lzoRN5gCeenXain9kMnZEYiRJfcYtQlnSXsLnZNFStuxg1oRlCVLnmEz9XFXFAkEA3OoopsAi6toF8SX7T7A0hogoTT1Hf0JxEDi0FwIArVcNRTdrKkEsoC1wAVgZGi9KIdxFYjbMlRRtHHjo+fSV1wJAXR7/jvZaEkxLF7mWCDFL84fBe6RONYsIPqVmbLFuNu60vJR9juSWVlL2ZjtfG3NPTCPJBz81s6TXUS8i95ASCQJAUg5sERw3HBLluCAKjBwANqRmi+IiJ4PvaT4WrqEgzUITfM1L8gMJZ2nZO7aUhGRiXddqskN2lD1lFflXWFjgOwJAAdEmCNKmulCLs7deGSaG9ie+LzJ4lDwEG0GBqVMD79FPFfgVi8dQOmR40Nhq9xQMlcVL1c6AvYh/5CWGHViCqw==';
//支付宝的公钥，查看地址：https://b.alipay.com/order/pidAndKey.htm
$alipay_config['alipay_public_key']= 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB';
// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['notify_url'] = "http://114.55.144.153:8889/notify_url.php";

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['return_url'] = "http://114.55.144.153:8889/return_url.php";

//签名方式
$alipay_config['sign_type']=strtoupper('RSA');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');
//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';

// 支付类型 ，无需修改
$alipay_config['payment_type'] = "1";

// 产品类型，无需修改
$alipay_config['service'] = "create_direct_pay_by_user";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


//↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
$alipay_config['anti_phishing_key'] = "";

// 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
$alipay_config['exter_invoke_ip'] = "";


return [
    'alipay_config'=>$alipay_config,
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
                        'name' => array('灵偶培养消耗经验'),
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
                        'name' => array('次日留存','三日留存','七日留存','十五日留存','月留存'),
                        'dataName' => array('每日登录人数'),
                    ),
//                    array(//三日留存
//                        'name' => array('每日登录人数'),
//                        'dataName' => array('每日登录人数'),
//                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '次日留存','三日留存','七日留存','十五日留存','月留存'),
                        'dataname' => $mouthName,
                    ),
//                    array(//三日留存
//                        'name' => '每日登录人数',
//                        'dataName' => array('每日登录人数'),
//                    )
                )

            ),
            //----留失----
            'retention_lost' => array(
                'tag' => array( //tag标签信息
                    array(//三日留存
                        'tagName'=>'用户留失数据',//标签名称
                        'name' => array('次日留失','三日留失','七日留失','十五日留失','月留失'),
                        'dataName' => array('每日登录人数'),
                    ),
//                    array(//三日留失
//                        'name' => array('每日登录人数'),
//                        'dataName' => array('每日登录人数'),
//                    )
                ),
                'tab_all' => array(
                    array(
                        'thred' => array($dateName, '次日留失','三日留失','七日留失','十五日留失','月留失'),
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
