<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/1/3
 * Time: 上午10:54
 */
namespace frontend\controllers;


use Yii;

/**
 * Index     controller
 */
class IndexController extends CommController
{

    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'character';
        return $this->render('index',
            array('action' => $action));
    }

    /**
     * 展示相关数据
     */
    public function actionGetdatas()
    {
        if (isset($_GET['page'])) {//查询
            $this->getData();
        }
        $allData = $this->createData();
        return $this->render('getdatas', array('all_data' => $allData));
    }


//
//     * 获取完整数据
//     * 完整数据由两部分组成,组合后生成完整的数据结构(json串通信协议) 提供给php和js
//     * 整个展示界面由图和表格组成,一般情况下每张图的数据和其中的一个表格是关联在一起的
//     * js负责生成和展示视图,php负责生成和展示表格,如果没有视图,php全部生成相关的代码
//     * 所有数据一次生成好之后,js负责图表的显示和隐藏,还有ajax的表格刷新
//     * 第一部分是配置相关数据
//     *          它包括报表的名称,报表title显示的字段 ,距离区间,各种配置参数等等.由配置文件读取
//     * 第二部分为有游戏数据仓库生成的数据
//     *
    private function createData()
    {
        //配置相关参数

        $conDatas = Yii::$app->params['tabConfig'];
        $key = $_GET['action'];
        $configDatas = $conDatas['gamePlayer'][$key];

        /**
         * 调用第一步生成游戏数据
         */
        //游戏相关数据 三个数据 游戏数据,当前第几页,总共多少页
        $allGame = $this->getData();
        //没有数据 返回
        if (!$allGame[0]) return $allGame;

        /**
         * 第二步为数据添加配置数据,并声称js可以使用的数据结构
         */
        //增加表格数据和tag标签名称
        foreach ($configDatas['tab_all'] as $k => $v) {
            array_unshift($allGame[$k]['tab'], $v['thred']);
            $allGame[$k]['tab'] = json_encode($allGame[$k]['tab']); //tab的时间标示
            //这个还得去大数组中去取
            $allGame[$k]['tag'] = $configDatas['tag'][$k];

            //为每个数据视图线提供数据名称
            $nameArr = $configDatas['tag'][$k]['name'] ;

            //---关键性数据----为每个视图生成seri数据
            foreach($nameArr as $key1=>$val1){
                $tmArr[] = array(
                    'name'=>$val1,
                    'data'=>$allGame[$k]['series'][$key1]
                );
            }

            $allGame[$k]['series'] = json_encode($tmArr) ;


        }
        return $allGame;

    }

    /**
     *  第一步生成数据,没有配上数据之外的标题 时间步长等数据
     *  根据不同的表格生成第一不同的第一步
     *
     * 这个方法需要动态生成数据 ,不能通用了
     */
    private function getData()
    {
        $tabName = "bi_log_" . $_GET['action'];
        $connection = Yii::$app->db;

        $where = 'where 1';

        if ($_GET['starttime']) {
            $where .= ' and f_time>=' . strtotime($_GET['starttime']);
        }

        if ($_GET['endtime']) {
            $where .= ' and f_time<=' . strtotime($_GET['endtime']);
        }

        //每日登录
        if ($tabName== 'bi_log_login'||$tabName== 'bi_log_retention') {
            return $this->createLoginData($connection,$where);
        } else {
            $sql = "SELECT * FROM  $tabName $where order BY f_time asc";
            $command = $connection->createCommand($sql);
            $allDatas = $command->queryAll();


            if (!$allDatas) return array(array());
//        var_dump($allDatas[0]) ;die;
//        if($_GET['action']=='character')
            $numArr = array();
            $dateArr = array();
            foreach ($allDatas as $k => $v) {
                foreach ($v as $k1 => $v1)
                    if ($k1 == 'f_time') {
                        $v1 = date("Y-m-d", $v1);
                        if (in_array($v1, $dateArr)) {
                            switch ($_GET['action']) {
                                case 'character' :
                                    $numArr[$v1]++;
                                    break;
                                case 'recharge':
                                    $numArr[$v1] += $v['f_recharge_yuanbao'];
                                    break;
                                case 'jinbi':
                                    $numArr[$v1] += $v['f_jinbi'];
                                    break;
                                case 'card_train':
                                    $numArr[$v1] += $v['f_jingyan_num'];
                                    break;
                                case 'skill_up'://技能功法消耗日志
                                    $numArr[$v1] += $v['f_goods_num'];
                                    break;
                                case 'jingjie_up'://境界修练日志
                                    $numArr[$v1] += $v['f_jingjie_num'];
                                    break;
                                case 'killboss'://boss击杀数量
                                    $numArr[$v1]++;
                                    break;
                                case 'yuanbao'://boss击杀数量
                                    $numArr[$v1] += $v['f_yuanbao'];
                                    break;
                            }

                        } else {
                            switch ($_GET['action']) {
                                case 'character' :
                                    $numArr[$v1] = 0;
                                    break;
                                case 'recharge':
                                    $numArr[$v1] = $v['f_recharge_yuanbao'];
                                    break;
                                case 'jinbi':
                                    $numArr[$v1] = $v['f_jinbi'];
                                    break;
                                case 'card_train':
                                    $numArr[$v1] = $v['f_jingyan_num'];
                                    break;
                                case 'skill_up'://技能功法消耗日志
                                    $numArr[$v1] = $v['f_goods_num'];
                                    break;
                                case 'jingjie_up'://境界修练日志
                                    $numArr[$v1] = $v['f_jingjie_num'];
                                    break;
                                case 'killboss'://boss击杀数量
                                    $numArr[$v1] = 0;
                                    break;
                                case 'yuanbao'://元宝获得数量
                                    $numArr[$v1] = $v['f_yuanbao'];
                                    break;
                            }
                            $dateArr[] = $v1;
                        }
                    }

            }
            $count = count($numArr);
        }

        foreach ($numArr as $k => $v) {
            $tabArr[] = array($k, $v);
            $serArr[] = doubleval($v);
        }
        //一个表格配置一个视图
        return array(array(
            'count' => $count,//总共多少条
            'categories' => json_encode($dateArr),//纯日期
            'series' => array($serArr), //这个还需要重新分配数组,如果是多维度
            'tab' => $tabArr
        ));

    }

    /**
     * 生成每日登陆的二级数据
     * 第一步生成数据,没有配上数据之外的标题 时间步长等数据
     */
    public function createLoginData($connection,$where)
    {
        $sql = "SELECT f_time from bi_count_login order by id desc limit 1";
        $command = $connection->createCommand($sql);
        $allDatas = $command->queryOne();
        if ($allDatas) {
            $sql = "SELECT f_time,num from bi_count_login $where" ;
            $command = $connection->createCommand($sql);
            $allDatas = $command->queryAll  ();
            $count = count($allDatas);
            foreach ($allDatas as $k => $v) {
                $date = date('Y-m-d',$v['f_time']) ;
                $categories[] =$date ; //视图日期
                $serArr[] = doubleval($v['num']) ; //视图数据
                $tabArr[] = array($date,$v['num']); //表格数据
            }
            return  array(array(
                'count' => $count,
                'categories' => json_encode($categories),
                'series' =>array($serArr), //这个还需要重新分配数组,如果是多维度
                'tab' => $tabArr
            ));

        } else {//初始化数据表
            //把昨天之前的数据写到数据库仓库
            //今天的数据实时生成
            $this->insertDb($connection);
        }


    }

    /**
     * 生成统计数据,写入数据库
     */
    public function insertDb($connection)
    {

        switch ($_GET['action']) {
            case "login":
                for($i=0;$i<30;$i++){
                    $start = strtotime(date("Y-m-d",strtotime("-$i day")));
                    $end   = strtotime(date("Y-m-d",time()-86400*($i-1)));
//                    $sql = "SELECT f_character_id, count(DISTINCT(f_character_id)) num from bi_log_login
//                            WHERE f_time>=$start AND f_time<$end  group by f_character_id
//                        " ;
                    $sql = "SELECT count(DISTINCT(f_character_id)) num from bi_log_login
                            WHERE f_time>=$start AND f_time<$end
                        " ;
                    $command = $connection->createCommand($sql);
                    $allDatas = $command->queryAll();
                    if($allDatas){
                        echo date("Y-m-d",$start).$sql."<br><br>" ;
                        foreach($allDatas as $v){
                            $tabName = "bi_count_login" ;
                            if($v['num']){
                                $data = array(
                                    'f_time'=>$start,
                                    'num'=>$v['num'],
                                );
                                $connection->createCommand()->insert($tabName, $data)->execute();
                            }
                        }

                    }

                }
                break;
            case "retention":
                for($i=0;$i<30;$i++){
                    $start = strtotime(date("Y-m-d",strtotime("-$i day")));
                    $end   = strtotime(date("Y-m-d",time()-86400*($i-1)));
//                    $sql = "SELECT f_character_id, count(DISTINCT(f_character_id)) num from bi_log_login
//                            WHERE f_time>=$start AND f_time<$end  group by f_character_id
//                        " ;
                    $sql = "SELECT count(DISTINCT(f_character_id)) num from bi_log_login
                            WHERE f_time>=$start AND f_time<$end
                        " ;
                    $command = $connection->createCommand($sql);
                    $allDatas = $command->queryAll();
                    if($allDatas){
                        echo date("Y-m-d",$start).$sql."<br><br>" ;
                        foreach($allDatas as $v){
                            $tabName = "bi_count_login" ;
                            if($v['num']){
                                $data = array(
                                    'f_time'=>$start,
                                    'num'=>$v['num'],
                                );
                                $connection->createCommand()->insert($tabName, $data)->execute();
                            }
                        }

                    }

                }
                break;
        }




    }
}
