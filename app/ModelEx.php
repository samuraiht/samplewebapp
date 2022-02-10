<?php
require_once 'db.php';

# 接続 失敗時処理中断
if(!connect()) {
	echo $link->connect_error;
	exit;
}

foreach($data['databases'] as $db) {
# データベースリセット
# DROP DATABASE `debug`;
	if($reset) execute("DROP DATABASE `{$db['name']}`;");

# データベース作成
# CREATE DATABASE IF NOT EXISTS `flower` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
	execute("CREATE DATABASE IF NOT EXISTS `{$db['name']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;");

# データベース選択
# USE `flower`;
	execute("USE `{$db['name']}`;");

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
		if(!empty($table['unique']) && count($table['unique'])){
			$cols .= ',UNIQUE(';
			$keys = '';
			foreach($table['unique'] as $key) {
				if($keys != '') $keys .= ',';
				$keys .= "`{$table['columns'][$key]['name']}`";
			}
			$cols .= "{$keys})";
		}

# CREATE TABLE IF NOT EXISTS `flower` (`id` INT UNSIGNED AUTO_INCREMENT,`name` VARCHAR(255) NOT NULL UNIQUE,`count` INT NOT NULL DEFAULT 0,PRIMARY KEY(`id`));
# CREATE TABLE IF NOT EXISTS `sqllog` (`id` BIGINT UNSIGNED AUTO_INCREMENT,`sql` TEXT ,`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,PRIMARY KEY(`id`));
		execute("CREATE TABLE IF NOT EXISTS `{$table['name']}` ({$cols});");

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
		execute("INSERT INTO `{$table['name']}` ({$keys}) VALUES {$vals};");
	}
}

# 外部キー制約
# ALTER TABLE `posts` ADD CONSTRAINT `icon01` FOREIGN KEY (`icon`) REFERENCES `images`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
if(!empty($data['relations'])) foreach($data['relations'] as $relation) execute("ALTER TABLE `{$relation['relation']['table']}` ADD CONSTRAINT `{$relation['name']}` FOREIGN KEY (`{$relation['relation']['column']}`) REFERENCES `{$relation['master']['database']}`.`{$relation['master']['table']}`(`{$relation['master']['column']}`) ON DELETE {$relation['delete']} ON UPDATE {$relation['update']};");

$msg = empty($link->error) ? 'データベース初期化完了' : $link->error;

disconnect();# 切断

echo json_encode(['result' => $msg]);# レスポンス
?>