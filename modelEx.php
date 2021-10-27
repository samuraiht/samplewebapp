<?php
require_once 'database.php';

# 接続 失敗時処理中断
if(!connect()) {
	echo $link->connect_error;
	exit;
}

# データベース作成
if($reset) execute("DROP DATABASE `{$database}`;");
execute("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;");

# データベース選択
execute("USE `{$database}`;");

foreach($tables as $table) {
# テーブル作成
	$cols = '';
	foreach($table['col'] as $col) {
		if($cols != '') $cols .= ',';
		$cols .= "`{$col['name']}` {$col['type']} {$col['attr']}";
	}
	if(!empty($table['pkey']) && count($table['pkey'])){
		$cols .= ',PRIMARY KEY(';
		$keys = '';
		foreach($table['pkey'] as $key) {
			if($keys != '') $keys .= ',';
			$keys .= "`{$table['col'][$key]['name']}`";
		}
		$cols .= "{$keys})";
	}
	execute("CREATE TABLE IF NOT EXISTS `{$table['name']}` ({$cols});");

#データ登録
	if(empty($table['data'])) continue;//$table['data']のキーがなければ次に行く
	$keys = '';
	foreach($table['data']['cols'] as $key) {
		if($keys != '') $keys .= ',';
		$keys .= "`{$table['col'][$key]['name']}`";
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
	execute("INSERT INTO `{$table['name']}` ({$keys}) VALUES {$vals};");
}
?>