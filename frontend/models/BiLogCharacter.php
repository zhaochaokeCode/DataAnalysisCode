<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bi_log_character".
 *
 * @property integer $id
 * @property integer $f_dept
 * @property integer $server_address_id
 * @property integer $game_id
 * @property integer $sid
 * @property integer $operative_id
 * @property integer $account_id
 * @property integer $character_id
 * @property string $character_ip
 * @property integer $character_type
 * @property string $time
 * @property integer $type
 * @property string $other
 */
class BiLogCharacter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bi_log_character';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_dept', 'server_address_id', 'game_id', 'sid', 'operative_id', 'account_id', 'character_id', 'character_ip', 'character_type', 'time', 'type', 'other'], 'required'],
            [['f_dept', 'server_address_id', 'game_id', 'sid', 'operative_id', 'account_id', 'character_id', 'character_type', 'type'], 'integer'],
            [['time'], 'safe'],
            [['character_ip'], 'string', 'max' => 15],
            [['other'], 'string', 'max' => 12],
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
            'server_address_id' => 'Server Address ID',
            'game_id' => 'Game ID',
            'sid' => 'Sid',
            'operative_id' => 'Operative ID',
            'account_id' => 'Account ID',
            'character_id' => 'Character ID',
            'character_ip' => 'Character Ip',
            'character_type' => 'Character Type',
            'time' => 'Time',
            'type' => 'Type',
            'other' => 'Other',
        ];
    }
}
