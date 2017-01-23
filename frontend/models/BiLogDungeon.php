<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bi_log_dungeon".
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
 * @property integer $f_dungeon_id
 * @property integer $f_nandu_id
 * @property integer $f_success
 * @property string $f_time
 * @property integer $f_type
 * @property string $f_other
 */
class BiLogDungeon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bi_log_dungeon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['f_dept', 'f_server_address_id', 'f_game_id', 'f_sid', 'f_operative_id', 'f_character_id', 'f_character_grade', 'f_character_ip', 'f_dungeon_id', 'f_nandu_id', 'f_success', 'f_time', 'f_type', 'f_other'], 'required'],
            [['f_dept', 'f_server_address_id', 'f_game_id', 'f_sid', 'f_operative_id', 'f_character_id', 'f_character_grade', 'f_dungeon_id', 'f_nandu_id', 'f_success', 'f_type'], 'integer'],
            [['f_time'], 'safe'],
            [['f_character_ip'], 'string', 'max' => 15],
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
            'f_dungeon_id' => 'F Dungeon ID',
            'f_nandu_id' => 'F Nandu ID',
            'f_success' => 'F Success',
            'f_time' => 'F Time',
            'f_type' => 'F Type',
            'f_other' => 'F Other',
        ];
    }
}
