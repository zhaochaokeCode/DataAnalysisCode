/*
Navicat MySQL Data Transfer

Source Server         : DataLogSer
Source Server Version : 50629
Source Host           : 116.62.100.98
Source Database       : data_analysis

Target Server Version : 50629
File Encoding         : utf-8

Date: 01/24/2017 10:07:01 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `bi_log_account`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_account`;
CREATE TABLE `bi_log_account` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_num` int(11) COMMENT '在线人数',
`f_VIP_num` int(11) COMMENT 'VIP在线人数',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_card_gain`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_card_gain`;
CREATE TABLE `bi_log_card_gain` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_model_id` int(11) COMMENT '灵偶id',
`f_id` int(11) COMMENT '卡牌唯一id',
`f_card_color` int(11) COMMENT '卡牌颜色',
`f_yuanbao_num` int(11) COMMENT '消耗的元宝数量',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_card_train`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_card_train`;
CREATE TABLE `bi_log_card_train` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_model_id` int(11) COMMENT '灵偶id',
`f_id` int(11) COMMENT '该角色拥有的卡牌唯一id ',
`f_card_color` int(11) COMMENT '卡牌颜色  按照品质从低到高0,1,2,3 表示',
`f_card_num` int(11) COMMENT '培养吞掉的卡牌数量 ',
`f_jingyan_num` int(11) COMMENT '培养过程中吸取的经验',
`f_card_before` int(11) COMMENT '吞卡之前的卡牌等级',
`f_card_after` int(11) COMMENT '吞卡之后的卡牌等级',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_character`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_character`;
CREATE TABLE `bi_log_character` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11),
`f_server_address_id` int(11),
`f_game_id` int(11),
`f_sid` int(11),
`f_yunying_id` int(11),
`f_account_id` int(11),
`f_character_id` int(11),
`f_character_ip` varchar(15),
`f_character_type` int(3),
`f_time` date,
`f_type` int(3),
`f_other` varchar(12),
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_character_grade`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_character_grade`;
CREATE TABLE `bi_log_character_grade` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_consumption`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_consumption`;
CREATE TABLE `bi_log_consumption` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_goods_model_id` varchar(20) COMMENT '购买的物品ID（便捷消费ID）',
`f_goods_price` int(11) COMMENT '物品价格',
`f_goods_num` int(11) COMMENT '购买的物品数量',
`f_consume_yuanbao_num` int(11) COMMENT '所消耗的元宝数量',
`f_overplus_yuanbao_num` int(11) COMMENT '剩余的元宝数量',
`f_yuanbao_channel` tinyint(8) COMMENT '货币类型',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_dungeon`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_dungeon`;
CREATE TABLE `bi_log_dungeon` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_dungeon_id` int(11) COMMENT '副本ID',
`f_nandu_id` int(11) COMMENT '副本难度',
`f_success` tinyint(8) COMMENT '成功与否',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_equip`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_equip`;
CREATE TABLE `bi_log_equip` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_model_id` int(11) COMMENT '装备模型id',
`f_id` int(11) COMMENT '角色装备id（角色装备的唯一ID）',
`f_goods_num` varchar(100) COMMENT '消耗材料数量',
`f_level_num` tinyint(8) COMMENT '强化后的装备等级',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_horse_tame`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_horse_tame`;
CREATE TABLE `bi_log_horse_tame` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_horse_model_id` int(11) COMMENT '强化前坐骑模型ID',
`f_horse_modelAfter_id` int(11) COMMENT '强化后坐骑模型ID',
`f_goodsParam` varchar(100) COMMENT '消耗材料数量',
`f_code` tinyint(8) COMMENT '强化类型',
`f_status` tinyint(8) COMMENT '强化类型',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_item`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_item`;
CREATE TABLE `bi_log_item` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_goods` varchar(20) COMMENT '道具模型ID',
`f_num` int(11) COMMENT '数量',
`f_opt_type` tinyint(3) COMMENT '操作类型',
`f_note` int(11) COMMENT '关联附属信息',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_jinbi`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_jinbi`;
CREATE TABLE `bi_log_jinbi` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_opt_type` tinyint(3) COMMENT '0 获得 1 消耗',
`f_jinbi` int(11) COMMENT '消耗数量',
`f_jinbi_after` int(3) COMMENT '剩余数量',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_jingjie_up`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_jingjie_up`;
CREATE TABLE `bi_log_jingjie_up` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_model_id` int(11) COMMENT '技能或者功法id',
`f_jingjie_num` int(11) COMMENT '强化后的境界',
`f_zhenqi_num` int(11) COMMENT '消耗的真气数量',
`f_jinbi_num` int(11) COMMENT '消耗的金币数量',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_killboss`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_killboss`;
CREATE TABLE `bi_log_killboss` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_BOSS_id` int(11) COMMENT 'BOSS的ID',
`f_dungeon_id` int(11) COMMENT 'BOSS的难度等级id',
`f_success` int(4) COMMENT '成功表示',
`f_nandu_id` int(11) COMMENT 'BOSS的难度等级id',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_login`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_login`;
CREATE TABLE `bi_log_login` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_type` int(3) COMMENT '角色类型id',
`f_vip_grade` int(3) COMMENT 'vip等级',
`f_fighting` int(11) COMMENT '角色战斗力',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_logout`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_logout`;
CREATE TABLE `bi_log_logout` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色登录ip',
`f_nstage_id` int(11) COMMENT '登出时最新普通剧情ID',
`f_sstage_id` int(11) COMMENT '登出时最新精英关卡ID',
`f_jinbi` int(11) COMMENT '登出时金币数量',
`f_yuanbao` int(11) COMMENT '登出时元宝数量',
`f_zhenqi` int(11) COMMENT '登出时真气数量',
`f_online_time` int(11) COMMENT '在线时长',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_online_character_cnt`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_online_character_cnt`;
CREATE TABLE `bi_log_online_character_cnt` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_num` int(11) COMMENT '在线人数',
`f_VIP_num` int(11) COMMENT 'VIP在线人数',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_recharge`;
CREATE TABLE `bi_log_recharge` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_recharge_yuanbao` int(11) COMMENT '充值获得的元宝数量',
`f_orderid` varchar(20) COMMENT '角色等级',
`f_discount` int(11) COMMENT '是否打折',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_skill_up`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_skill_up`;
CREATE TABLE `bi_log_skill_up` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_model_id` int(11) COMMENT '技能或者功法id',
`f_goods_num` varchar(100) COMMENT '消耗材料数量',
`f_level_num` tinyint(8) COMMENT '强化后的装备等级',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_stage`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_stage`;
CREATE TABLE `bi_log_stage` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_stage_id` int(11) COMMENT '剧情关卡ID',
`f_stage_ns` varchar(10) COMMENT '剧情关卡分类',
`f_code` tinyint(8) COMMENT '成功与否',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `bi_log_yuanbao`
-- ----------------------------
DROP TABLE IF EXISTS `bi_log_yuanbao`;
CREATE TABLE `bi_log_yuanbao` (
`id` int(11) AUTO_INCREMENT,
`f_dept` int(11) COMMENT '平台id',
`f_server_address_id` int(11) COMMENT '服务器地址ID',
`f_game_id` int(11) COMMENT '游戏id',
`f_sid` int(11) COMMENT '服务器ID,若发生合服，此地址不变',
`f_yunying_id` int(11) COMMENT '运营id',
`f_character_id` int(11) COMMENT '角色id',
`f_character_grade` int(11) COMMENT '角色等级',
`f_character_ip` varchar(15) COMMENT '角色ip',
`f_opt_type` tinyint(3) COMMENT '操作类型 0 商城购买 1卡牌抽取 2充值获得元宝 3系统奖励元宝',
`f_yuanbao` int(11) COMMENT '数量',
`f_opttype` int(3) COMMENT '购买后数量',
`f_time` date COMMENT '时间',
`f_type` int(3) COMMENT '日志仓库类型（日，周，月）',
`f_other` varchar(12) COMMENT '其它备用类型',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
