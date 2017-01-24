<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/1/3
 * Time: 上午10:54
 */
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Index     controller
 */
class IndexController extends Controller
{

    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
        $action = isset($_GET['action'])?$_GET['action']:'character' ;
        return $this->render('index',
                        array('action'=>$action));
    }

    /**
     * 展示相关数据
     */
    public function actionGetdatas()
    {
        if($_GET['page']){//查询
            $this->getData() ;
        }
        $allData = $this->createData();
        return $this->render('getdatas', array(

                //展示表格数据
                'view_arr' => $allData[0], //php端数据 遍历生成表格和tab
                'tab_arr' => $allData[0],//php端数据  遍历生成表格和tab


                //分页
                'page' => $allData[2],
                'count' => $allData[3],


                //视图数据
                'view_data' => json_encode($allData[0]), //json端数据
                'tab_data' => json_encode($allData[1]), //json端数据

                //url
//                'url'=>$url


            )
        );
    }

    /**
     * 测试分页
     */
    public function actionPages()
    {
        return $this->render('pageshow');
    }


    /**
     * 获取完整数据
     * 完整数据由两部分组成,组合后生成完整的数据结构(json串通信协议) 提供给php和js
     * 整个展示界面由图和表格组成,一般情况下每张图的数据和其中的一个表格是关联在一起的
     * js负责生成和展示视图,php负责生成和展示表格,如果没有视图,php全部生成相关的代码
     * 所有数据一次生成好之后,js负责图表的显示和隐藏,还有ajax的表格刷新
     * 第一部分是配置相关数据
     *          它包括报表的名称,报表title显示的字段 ,距离区间,各种配置参数等等.由配置文件读取
     * 第二部分为有游戏数据仓库生成的数据
     *
     */
    private function createData()
    {
        //配置相关参数







        $conDatas = Yii::$app->params['tabConfig'];
        $key = $_GET['action'];
        $configDatas = $conDatas['gamePlayer'][$key];

        //游戏相关数据 三个数据 游戏数据,当前第几页,总共多少页
        $allGame = $this->getData();

        $gameDatas = $allGame['tab_data'];

        //--------视图hightcharts相关数据结构---------循环两次
        //把游戏相关数据加到原来的配置数据结构中 ,key为新的series
        //游戏数据是一条一条插进去的 所以每次$gameDatasKey 需要加一,取下一条 这个是难点
        foreach ($configDatas['tag'] as $k => $v) {

            foreach ($v['dataName'] as $key1 => $val1) {
                $configDatas[$k]['series'][] =
                    array('name' => $val1,
                        'data' => $gameDatas[$k][$key1]);
            }
            if ($v['categories']) {
                $configDatas[$k]['categories'] = $v['categories'];
            } else {
                $configDatas[$k]['categories'] = '';
            }
        }

        //--------表格相关数据结构------不管tab多少数据  循环三次
        $tabDataConf = $configDatas['tab_all'];

        //首先是两个表格
        foreach ($tabDataConf as $k => $v) {
            //取得每个数组的第一个元素组成一个新数组

            $columnNum = count($v['thred']) - 1;//列数
            $lineNum = count($gameDatas[$k][0]); //行数
            $newArr = array();
            for ($m = 0; $m < $lineNum; $m++) {
                $newArr[$m][] = $v['dataname'][$m];//第一行是名称,不计入计算
                for ($j = 0; $j < $columnNum; $j++) {
                    $newArr[$m][] = $gameDatas[$k][$j][$m];
                }
            }

            array_unshift($newArr, $v['thred']);
            $tabData[] = $newArr;
        }

        return array($configDatas, $tabData,$allGame['pages'],
            $allGame['count'],);

    }




    /**
     * @param 游戏数据仓库相关数据
     * 根据get参数判断
     */
    private function getData()
    {

        $tabName =  "bi_log_".$_GET['action'] ;

        $connection = Yii::$app->db ;
        $command = $connection->createCommand("SELECT * FROM  $tabName");
        $posts = $command->queryAll();

        var_dump($posts) ;


//        $data1 = array(explode(',', '100.0,6.9,9.5,14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6' ));
        $data1 = explode(',', '100.0,6.9,9.5,14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6');
//        $data1[] =  $data1[0] ;
        $data2 = explode(',', '-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5');
        foreach ($data1 as &$v) {
            $v = (double)$v;
        }
        foreach ($data2 as &$v) {
            $v = (double)$v;
        }
        $count = 100;
        $pages = 10;

        $ret = array(
            'tab_data' => array(//所有table的数据
                array($data1, $data2),
                array($data2),
                array($data2)
            ),
            'count' => $count,
            'pages' => $pages

        );
        return $ret;

    }


}
