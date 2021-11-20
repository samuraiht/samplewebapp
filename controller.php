<?php
require_once 'database.php';

# index.phpから呼び出される
function options() {
	global $link;
# 接続 失敗時処理中断
	if(!connect('flower')) return;

# flowerから花一覧を取得
	$list = select('SELECT `name` FROM `flower`;');

# 切断
	$link->close();

# <option value="Rose">Rose</option><option value="SunFlower">SunFlower</option><option value="Tulip">Tulip</option>
	$html = '';
	foreach($list as $item) $html .= '<option value="' . $item['name'] . '">' . $item['name'] . '</option>';
	echo $html;
}

# admin.phpから呼び出される
function flowerlist() {
	global $link;
# 接続 失敗時処理中断
	if(!connect('flower')) return;

# 管理画面の品目一覧のテーブルHTMLを生成
	include 'showData.php';

# 切断
	$link->close();

	echo $html;
}
?>