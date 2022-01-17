<?php
require_once 'database.php';

# 接続 失敗時処理中断
if(!connect()) {
	echo $link->connect_error;
	exit;
}

$log = [];

foreach($data as $db) {
# データベースリセット
	if($reset) {
# DROP DATABASE `flower`;
		$sql = "DROP DATABASE `{$db['name']}`;";
		$log[] = $sql;
		execute($sql);
	}

# データベース作成
# CREATE DATABASE IF NOT EXISTS `flower` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
	$sql = "CREATE DATABASE IF NOT EXISTS `{$db['name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;";
	$log[] = $sql;
	execute($sql);

# データベース選択
# USE `flower`;
	$sql = "USE `{$db['name']}`;";
	$log[] = $sql;
	execute($sql);

# テーブル作成
	foreach($db['tables'] as $table) {
		$cols = '';
		foreach($table['columns'] as $col) {
			if($cols != '') $cols .= ',';
			$cols .= "`{$col['name']}` {$col['type']} {$col['attr']}";
		}
		if(!empty($table['pkey']) && count($table['pkey'])){
			$cols .= ',PRIMARY KEY(';
			$keys = '';
			foreach($table['pkey'] as $key) {
				if($keys != '') $keys .= ',';
				$keys .= "`{$table['columns'][$key]['name']}`";
			}
			$cols .= "{$keys})";
		}

# CREATE TABLE IF NOT EXISTS `flower` (`id` INT UNSIGNED AUTO_INCREMENT,`name` VARCHAR(255) NOT NULL UNIQUE,`count` INT NOT NULL DEFAULT 0,PRIMARY KEY(`id`));
# CREATE TABLE IF NOT EXISTS `sqllog` (`id` BIGINT UNSIGNED AUTO_INCREMENT,`sql` TEXT ,`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(`id`));
		$sql = "CREATE TABLE IF NOT EXISTS `{$table['name']}` ({$cols});";
		$log[] = $sql;
		execute($sql);

# データ登録
		if(empty($table['data'])) continue;//$table['data']のキーがなければ次に行く
		$keys = '';
		foreach($table['data']['columns'] as $key) {
			if($keys != '') $keys .= ',';
			$keys .= "`{$table['columns'][$key]['name']}`";
		}
		$vals = '';
		foreach($table['data']['values'] as $val) {
			if($vals != '') $vals .= ',';
			$vals .= '(';
			$itemtext = '';
			foreach($val as $item) {
				if($itemtext != '') $itemtext .= ',';
				$itemtext .= is_null($item) ? 'NULL' : (is_numeric($item) ? $item : "'{$item}'");
			}
			$vals .= $itemtext . ')';
		}

# INSERT INTO `flower` (`name`,`count`) VALUES ('Rose',4),('SunFlower',7),('Tulip',5);
		$sql = "INSERT INTO `{$table['name']}` ({$keys}) VALUES {$vals};";
		$log[] = $sql;
		execute($sql);
	}
}
$sql = '';
foreach($log as $s) {
	if($sql) $sql .= ',';
	$sql .= "('" . str_replace("'", "''", $s) . "')";
}
execute("INSERT INTO `debug`.`sqllog` (`sql`) VALUES{$sql};");
?>