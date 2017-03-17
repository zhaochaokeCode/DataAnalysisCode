<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/1/3
 * Time: 上午10:54
 */
namespace frontend\controllers;


use Yii;
use app\models\BiCountCustomerChurn ;

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
        $allGame = $this->getData();
        $allData = $this->createData($allGame);
        return $this->render('getdatas', array('all_data' => $allData));
    }


    /**
     *  第一步生成数据,没有配上数据之外的标题 时间步长等数据
     * 这个方法需要动态生成数据 ,不能通用了
     */
    private function getData()
    {
        $tabName = "bi_log_" . $_GET['action'];

        $where = $this->where;
        $funName = $this->getFuntionName();
        return $this->$funName($where, $tabName);
    }
    /**
     *
     * 生成每日登陆的二级数据
     * 第一步生成数据,没有配上数据之外的标题 时间步长等数据
     */
    public function loginCreateData($where)
    {
        $connection = Yii::$app->db ;
        $sql = "SELECT f_time from bi_count_login order by id desc limit 1";
        $command = $connection->createCommand($sql);
        $allDatas = $command->queryOne();
        if ($allDatas) {
            $sql = "SELECT f_time,num from bi_count_login $where";
            $command = $connection->createCommand($sql);
            $allDatas = $command->queryAll();
            $count = count($allDatas);
            foreach ($allDatas as $k => $v) {
                $date = date('Y-m-d', $v['f_time']);
                $categories[] = $date; //视图日期
                $serArr[] = doubleval($v['num']); //视图数据
                $tabArr[] = array($date, $v['num']); //表格数据
            }
            return array(array(
                'count' => $count,
                'categories' => json_encode($categories),
                'series' => array($serArr), //这个还需要重新分配数组,如果是多维度
                'tab' => $tabArr
            ));

        } else {//初始化数据表
            //把昨天之前的数据写到数据库仓库
            //今天的数据实时生成
            $this->insertDb($connection);
        }
    }

    private function commCreateData( $where, $tabName)
    {
        $connection = Yii::$app->db;
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
     * @param $where1
     * @param $tabName
     */
    public function customerChurnCreateData(){
        echo '流失' ;

        
        
        
        
    }
    public function logoutCreateData(){
        $tabName = 'bi_count_logout' ;
        $start  = strtotime($_GET['starttime'] );

        $end = strtotime($_GET['endtime']) ;
        if($end-$start<86400){
            $len = 1;
        }else{
            $len = floor(($end-$start)/86400) ;
        }

        $groupBy = ' f_dept,f_game_id,f_sid ' ;



        for($i=0;$i<$len;$i++){
            $stime = $start+86400*$i ;
            $etime = $stime+86400*($i+1) ;



            //当日退出的关卡
            $where = " where f_time>=$stime and f_time<$etime and f_type=1 " ;
            $sql = "SELECT * FROM $tabName $where  group by $groupBy order BY f_time  asc";
            $command = Yii::$app->db->createCommand($sql);
            $nsDatas = $command->queryAll();




            foreach($nsDatas as $k=>$v){
                $tabArr[] = array($k, $v);

            }







            //当日退出的场景
            $where = " f_time>=$stime and f_time<$etime and type=1 " ;
            $sql = "SELECT * FROM $tabName  $where group by $groupBy order BY f_time  asc";
            $command = Yii::$app->db->createCommand($sql);
            $ssDatas = $command->queryAll();
        }

    }
}
