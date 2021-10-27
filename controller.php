<?php
require_once 'database.php';

# index.phpから呼び出される
function options() {
	global $link;
# 接続 失敗時処理中断
	if(!connect('flower')) return;

# flowerから花一覧を取得
	$list = select('SELECT `name` FROM `flower`;');

# <option value="Rose">Rose</option>
	$html = '';
	foreach($list as $item) $html .= '<option value="' . $item['name'] . '">' . $item['name'] . '</option>';

# 切断
	$link->close();

	echo $html;
}

# admin.phpから呼び出される
function flowerlist() {
	global $link;
# 接続 失敗時処理中断
	if(!connect('flower')) return;
	
# flowerから花一覧を取得
	$list = select('SELECT `id`,`name`,`count` FROM `flower`;');

# <tr><td class="id">1</td><td class="name">Rose</td><td class="count">4</td><td><button data-id="1" class="edit">編集</button></td></tr>
	$html = '';
	foreach($list as $item) $html .= '<tr data-id="' . $item['id'] . '"><td class="id">' . $item['id'] . '</td><td class="name">' . $item['name'] . '</td><td class="count">' . $item['count'] . '</td><td><button data-id="' . $item['id'] . '" data-name="' . $item['name'] .  '" data-count="' . $item['count'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete">削除</button></td></tr>';

# 切断
	$link->close();

	echo $html;
}
?>