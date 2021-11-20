<?php
# flowerから花一覧を取得
	$sql = 'SELECT `id`,`name`,`count`,`price`,`point` FROM `flower`;';
	$list = select($sql);

# 実行したSQLの記録
	execute("INSERT INTO `sqllog` (`sql`) VALUES('" . str_replace("'", "''", $sql) . "');");

# <tr data-id="1"><td>1</td><td>Rose</td><td class="number">4</td><td class="number">400</td><td class="number">0</td><td><button data-id="1" data-name="Rose" data-count="4" data-price="400" data-point="0" class="update">編集</button></td><td><button data-id="1" class="delete warn">削除</button></td></tr>
	$html = '';
	foreach($list as $item) $html .= '<tr data-id="' . $item['id'] . '"><td>' . $item['id'] . '</td><td>' . $item['name'] . '</td><td class="number">' . $item['count'] . '</td><td class="number">' . $item['price'] . '</td><td class="number">' . $item['point'] . '</td><td><button data-id="' . $item['id'] . '" data-name="' . $item['name'] .  '" data-count="' . $item['count'] . '" data-price="' . $item['price'] . '" data-point="' . $item['point'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete warn">削除</button></td></tr>';
?>