<?php
/**
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 17/4/7
 * Time: 上午10:36
 */
$conn  = new MongoClient('mongodb://root:cthy8566@dds-m5ea0bb2c4c1c5f41.mongodb.rds.aliyuncs.com:3717');
if(isset($_GET['user_id'])){
    $id = $_GET['user_id'] ;
    $data = $this->table->findone(["_id" => new MongoId($id)]);
    echo json_encode($data) ;die;
}
