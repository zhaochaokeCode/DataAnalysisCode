<?php
/**
 *
 * Created by PhpStorm.
 * User: zhaochaoke
 * Date: 16/12/30
 * Time: 上午11:46
 */



$str = 'order_id=2017030321001004280223720066other=1time=2017-03-0315:40:33total_money=0.01EoL32&JSUVt30JHir6v48sk!' ;

$str = 'order_id=2017030321001004280223724368other=1time=2017-03-0315:56:36total_money=0.01EoL32&JSUVt30JHir6v48sk!' ;
echo md5($str);