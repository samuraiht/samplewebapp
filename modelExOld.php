<?php
require_once 'database.php';

# 接続 失敗時処理中断
if(!connect()) exit;

# データベース作成
if($reset) execute('DROP DATABASE `flower`;', true);
execute('CREATE DATABASE IF NOT EXISTS `flower` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;', true);

# データベース選択
execute('USE `flower`;', true);

# テーブル作成
execute('CREATE TABLE IF NOT EXISTS `flower` (`id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,`name` TINYTEXT NOT NULL,`count` INT NOT NULL DEFAULT 0);', true);

# 元データ
$data = [
	[
		'name' => 'Rose',
		'count' => 4
	],
	[
		'name' => 'SunFlower',
		'count' => 7
	],
	[
		'name' => 'StarAnis',
		'count' => 13
	]
];

# データ登録
$val = '';
foreach($data as $item) {
	if($val != '') $val .= ',';
	$val .= "('" . $item['name'] . "'," . $item['count'] . ')';
}
execute('INSERT INTO `flower` (`name`,`count`) VALUES' . $val, true);
?>