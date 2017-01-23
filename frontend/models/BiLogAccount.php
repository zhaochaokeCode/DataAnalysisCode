<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bi_log_account".
 *
 * @property integer $id
 * @property integer $f_dept
 * @property integer $f_server_address_id
 * @property integer $f_game_id
 * @property integer $f_num
 * @property integer $f_VIP_num
 * @property string $f_time
 * @property integer $f_type
 * @property string $f_other
 */
class BiLogAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bi_log_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_dept', 'f_server_address_id', 'f_game_id', 'f_num', 'f_VIP_num', 'f_time', 'f_type', 'f_other'], 'required'],
            [['f_dept', 'f_server_address_id', 'f_game_id', 'f_num', 'f_VIP_num', 'f_type'], 'integer'],
            [['f_time'], 'safe'],
            [['f_other'], 'string', 'max' => 12],
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
            'f_server_address_id' => 'F Server Address ID',
            'f_game_id' => 'F Game ID',
            'f_num' => 'F Num',
            'f_VIP_num' => 'F  Vip Num',
            'f_time' => 'F Time',
            'f_type' => 'F Type',
            'f_other' => 'F Other',
        ];
    }
}
