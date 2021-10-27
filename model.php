<?php
#データベース作り直しするかどうか
$reset = true;

#データベース名
$database = 'flower';

#テーブルデータ
$tables = [
	[
		'name' => 'flower',
		'col' => [
			[
				'name' => 'id',
				'type' => 'INT',# -2147483648 ~ 2147483647の整数
				'attr' => 'UNSIGNED AUTO_INCREMENT'# 符号なしなので、範囲が変わります(0 ~ 4294967295)
			],
			[
				'name' => 'name',
				'type' => 'TINYTEXT',# 255バイト以下の文字列
				'attr' => NULL
			],
			[
				'name' => 'count',
				'type' => 'INT',# -2147483648 ~ 2147483647の整数
				'attr' => 'NOT NULL DEFAULT 0'
			]
		],
		'pkey' => [0],
		'data' => [
			'cols' => [1, 2],
			'values' => [
				['Rose', 4],
				['SunFlower', 7],
				['Tulip', 13]
			]
		]
	]
];

#処理の呼び出し
require_once 'modelEx.php';

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