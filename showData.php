<?php
# flowerから花一覧を取得
	$sql = 'SELECT `id`,`name`,`count`,`price`,`point`,`shipping` FROM `flower`;';
	$list = select($sql);

# 実行したSQLの記録
	execute("INSERT INTO `sqllog` (`sql`) VALUES('" . str_replace("'", "''", $sql) . "');");

# <tr data-id="1"><td>1</td><td data-col="name">Rose</td><td data-col="count" class="number">4</td><td data-col="price" class="number">400</td><td data-col="point" class="number">0</td><td data-col="shipping" class="number">0</td><td><button data-id="1" data-name="Rose" data-count="4" data-price="400" data-point="0" data-shipping="0" class="update">編集</button></td><td><button data-id="1" class="delete warn">削除</button></td></tr>
	$html = '';
	foreach($list as $item) $html .= '<tr data-id="' . $item['id'] . '"><td data-col="id">' . $item['id'] . '</td><td data-col="name">' . $item['name'] . '</td><td data-col="count" class="number">' . $item['count'] . '</td><td data-col="price" class="number">' . $item['price'] . '</td><td data-col="point" class="number">' . $item['point'] . '</td><td data-col="shipping" class="number">' . $item['shipping'] . '</td><td><button data-id="' . $item['id'] . '" data-name="' . $item['name'] .  '" data-count="' . $item['count'] . '" data-price="' . $item['price'] . '" data-point="' . $item['point'] . '" data-shipping="' . $item['shipping'] . '" class="update">編集</button></td><td><button data-id="' . $item['id'] . '" class="delete warn">削除</button></td></tr>';
?>