<?php
namespace frontend\controllers;


use Yii ;
use yii\web\Controller;


class ReigstController extends Controller
{
    public function init()
    {
        switch ($_POST['action']) {
            //检测手机号
            case 'check':
                $this->getIdentifying();
                break;
            case 'get_regist_code':
                $this->getRegistCode();
                break;
            //检测注册验证码
            case 'check_regist_code':
                $this->checkRegistCode();
                break;
            case 'regist_user':
                $this->registUser();
                break;
            case 'login_user':
                $this->login();
                break ;
            case 'get_change_pass'://获取修改密码的验证码
                $this->getRegistCode();
                break ;
            case 'change_password':
                $this->changePass();
                break ;
        }
    }
    /**
     * 获取手机验证码
     */
    public function getIdentifying()
    {
        $ret = $this->getUserInfo($_POST['phone_num']);
        //手机号码已经存在
        if ($ret) {
            $this->returnResu();
            //发送验证码
        } else {
            $this->getRegistCode();
        }

    }

    /**
     * 发送验证吗
     * tmp 为true 强制重新生成验证码
     */
    public function getRegistCode($tmp=true)
    {

        //获取手机号验证码
        $data = $this->getMobileCode($_POST['phone_num']);
        //重新生成注册码
        if($data){
            $where = array('id' => $data['id']);
            if($tmp){//如果需要强制刷新验证码
                $data = $this->createCode();
                $data['phone'] =  $_POST['phone_num'] ;
                //更新数据库
                DB::update('mobile_register_code', $data, $where);
            }else {
                //
                if (($data && time() - $data['code_time'] > 300)) {
                    $data = $this->createCode();
                    //更新数据库
                    DB::update('mobile_register_code', $data, $where);
                }
            }
        }else{
            $data = $this->createCode();
            $data['phone'] =  $_POST['phone_num'] ;
            //更新数据库
            DB::insert('mobile_register_code', $data);
        }
        $code = $data['register_code'];
        $phone = $_POST['phone_num'];
        $url = "https://dx.ipyy.net/sms.aspx?action=send&userid=&account=AA00645&password=AA0064555&mobile=$phone&content=您好,您的验证码是:$code【百文互娱】";
        $this->curlData($url);
        $this->returnResu(true);
    }

    private function createCode()
    {
        $data['register_code'] = rand(1000, 9999);
        $data['code_time'] = time();
        return $data ;
    }

    /**
     * 检测手机验证码
     */
    public function checkRegistCode($tmp = false)
    {
        $data = $this->getMobileCode($_POST['phone_num']);
        if ($data&&($_POST['register_code'] == $data['register_code'])) {
            //有检测码 但是已经过期
            if(time()-$data['code_time']>6000){
                $this->returnResu(false, 'code timeout');
            }

            //如果注册的时候检测验证码,正确的话 直接返回 不需要输出
            if ($tmp) return  true;
            //数据校对结果
            $this->returnResu(true);
        }
        //注册码不对
        $this->returnResu(false, 'fail');
    }

    /**
     * 注册用户
     */

    public function   registUser()
    {
        $userName = $_POST['phone_num'];
        $password = $_POST['password'];

        $dataArr = array(
            "phone_num" => $userName,
            "password" => md5($password),

        );
        if ($_POST['register_code']) {
            $this->checkRegistCode(true);
        }
        if (!$this->getUserInfo($userName)) {

            $ret = DB::insert('mobile_user', $dataArr,true);
            if ($ret) {
                $this->returnResu(
                    array('phone_num' => $userName,
                        'user_id' => $ret,
                        'name'=>''
                    )
                );
            } else {
                $this->returnResu();
            }
        } else {
            $this->returnResu(false, 'same phone_um');
        }


    }
    public function login(){
        $data = $this->getUserInfo($_POST['phone_num']) ;
        if($data){
            if($data['password']==md5($_POST['password'])){
                unset($data['password']) ;
                $data['user_id'] = $data['id'] ;
                unset($data['id'] ) ;
                $this->returnResu($data);
            }else{
                $this->returnResu(false,'pwssword wrong');
            }
        }else{
            $this->returnResu(false,'phone_num wrong');
        }
    }


    public function changePass(){
        $data = $this->checkRegistCode(true);
        if($data){
            $dataArr = array('password'=>md5($_POST['password']));
            $where   = array('phone_num'=>$_POST['phone_num']) ;
            $res = DB::update('mobile_user', $dataArr, $where);
            if($res){
                $this->returnResu(true);
            }
        }
        $this->returnResu(false,'change fail');
    }


    /**
     * @param $array
     * 通用格式返回数据结果的json串
     * 默认没有参数 就是失败
     */

    private function returnResu($data = false, $err = false)
    {
        $code = $data ? self::SUCCESS : self::FAIL;
        $message = $err ? $err : 'success';
        $retArr = array(
            "code" => $code,
            "messsage" => $message,
            "cost_time" => 0,
            "data" => $data
        );
        echo json_encode($retArr);
        die;
    }

    /**
     * 得到手机号验证码
     */
    private function getMobileCode($phoneNum)
    {
        $sql = "SELECT * from pre_mobile_register_code WHERE
                              phone='$phoneNum'";
        $ret = DB::fetch_all($sql);
        return $ret ? $ret[0] : $ret;
    }

    /**
     * 得到用户信息
     */
    private function getUserInfo($phoneNum)
    {
        $sql = "SELECT * from pre_mobile_user WHERE
                              phone_num='$phoneNum'";
        $ret = DB::fetch_all($sql);
        return $ret ? $ret[0] : $ret;
    }

    private function curlData($url)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
    }


}






