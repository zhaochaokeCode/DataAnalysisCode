<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bi_count_customer_churn".
 *
 * @property integer $id
 * @property integer $f_dept
 * @property integer $f_game_id
 * @property integer $f_sid
 * @property integer $f_out_id
 * @property integer $f_out_num
 * @property integer $f_type
 * @property integer $f_time
 */
class BiCountCustomerChurn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bi_count_customer_churn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_dept', 'f_game_id', 'f_sid', 'f_out_id', 'f_out_num', 'f_type', 'f_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'f_dept' => 'F Dept',
            'f_game_id' => 'F Game ID',
            'f_sid' => 'F Sid',
            'f_out_id' => 'F Out ID',
            'f_out_num' => 'F Out Num',
            'f_type' => 'F Type',
            'f_time' => 'F Time',
        ];

    }


}
