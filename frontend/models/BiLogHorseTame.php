<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bi_log_horse_tame".
 *
 * @property integer $id
 * @property integer $f_dept
 * @property integer $f_server_address_id
 * @property integer $f_game_id
 * @property integer $f_sid
 * @property integer $f_operative_id
 * @property integer $f_character_id
 * @property integer $f_character_grade
 * @property string $f_character_ip
 * @property integer $f_horse_model_id
 * @property integer $f_horse_modelAfter_id
 * @property string $f_goodsParam
 * @property integer $f_code
 * @property integer $f_status
 * @property string $f_time
 * @property integer $f_type
 * @property string $f_other
 */
class BiLogHorseTame extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bi_log_horse_tame';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_dept', 'f_server_address_id', 'f_game_id', 'f_sid', 'f_operative_id', 'f_character_id', 'f_character_grade', 'f_character_ip', 'f_horse_model_id', 'f_horse_modelAfter_id', 'f_goodsParam', 'f_code', 'f_status', 'f_time', 'f_type', 'f_other'], 'required'],
            [['f_dept', 'f_server_address_id', 'f_game_id', 'f_sid', 'f_operative_id', 'f_character_id', 'f_character_grade', 'f_horse_model_id', 'f_horse_modelAfter_id', 'f_code', 'f_status', 'f_type'], 'integer'],
            [['f_time'], 'safe'],
            [['f_character_ip'], 'string', 'max' => 15],
            [['f_goodsParam'], 'string', 'max' => 100],
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
            'f_sid' => 'F Sid',
            'f_operative_id' => 'F Operative ID',
            'f_character_id' => 'F Character ID',
            'f_character_grade' => 'F Character Grade',
            'f_character_ip' => 'F Character Ip',
            'f_horse_model_id' => 'F Horse Model ID',
            'f_horse_modelAfter_id' => 'F Horse Model After ID',
            'f_goodsParam' => 'F Goods Param',
            'f_code' => 'F Code',
            'f_status' => 'F Status',
            'f_time' => 'F Time',
            'f_type' => 'F Type',
            'f_other' => 'F Other',
        ];
    }
}
