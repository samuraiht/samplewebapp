<?php
# データベース作り直しするかどうか
$reset = true;

# 処理の呼び出し
require_once 'modelExOld.php';

# 備考：controller.php + model.php + ajax.phpに同じ記載があります。
# ----------------------------------------------------------------
# flowerから花一覧を取得
$list = select('SELECT `id`,`name`,`count` FROM `flower`;');

# <tr><td class="id">1</td><td class="name">Rose</td><td class="count">4</td><td><button data-id="1" data-name="Rose" data-count="4" class="update">編集</button></td><td><button data-id="1" class="delete warn">削除</button></td></tr>
$html = '';
foreach($list as $item) $html .= '<tr data-id="' . $item['id'] . '"><td class="id">' . $item['id'] . '</td><td class="name">' . $item['name'] . '</td><td class="count">' . $item['count'] . '</td><td><button data-id="' . $item['id'] . '" data-name="' . $item['name'] .  '" data-count="' . $item['count'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete warn">削除</button></td></tr>';
# ----------------------------------------------------------------

# 切断
$link->close();

$json = [
	'result' => '初期化完了',
	'html' => $html
];
echo json_encode($json);
?>