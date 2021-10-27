<?php
#データベース作り直しするかどうか
$reset = true;

#処理の呼び出し
require_once 'modelExOld.php';

# flowerから花一覧を取得
$list = select('SELECT `id`,`name`,`count` FROM `flower`;');

# <tr><td class="id">1</td><td class="name">Rose</td><td class="count">4</td><td><button data-id="1" class="edit">編集</button></td></tr>
$html = '';
foreach($list as $item) $html .= '<tr data-id="' . $item['id'] . '"><td class="id">' . $item['id'] . '</td><td class="name">' . $item['name'] . '</td><td class="count">' . $item['count'] . '</td><td><button data-id="' . $item['id'] . '" data-name="' . $item['name'] .  '" data-count="' . $item['count'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete">削除</button></td></tr>';
$json = [
	'result' => '初期化完了',
	'html' => $html
];
echo json_encode($json);

#切断
$link->close();
?>