<?php
# データベース作り直しするかどうか
$reset = true;

# データベース名
$database = 'flower';

# テーブルデータ
$tables = [
	[
		'name' => 'sqllog',
		'col' => [
			[
				'name' => 'id',
				'type' => 'BIGINT',# -2147483648 ~ 2147483647の整数
				'attr' => 'UNSIGNED AUTO_INCREMENT'# 符号なしなので、範囲が変わります(0 ~ 4294967295)
			],
			[
				'name' => 'sql',
				'type' => 'TEXT',# 65535バイト以下の文字列
				'attr' => NULL
			],
			[
				'name' => 'date',
				'type' => 'TIMESTAMP',# -2147483648 ~ 2147483647の整数
				'attr' => 'NOT NULL DEFAULT CURRENT_TIMESTAMP'
			]
		],
		'pkey' => [0]# PRIMARY KEYにするカラムの番号
	],
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
				'type' => 'VARCHAR(255)',# 255バイト以下の文字列
				'attr' => 'NOT NULL UNIQUE'
			],
			[
				'name' => 'count',
				'type' => 'INT',# -2147483648 ~ 2147483647の整数
				'attr' => 'NOT NULL DEFAULT 0'
			],
			[
				'name' => 'price',
				'type' => 'INT',# -2147483648 ~ 2147483647の整数
				'attr' => 'UNSIGNED NOT NULL DEFAULT 0'# 符号なしなので、範囲が変わります(0 ~ 4294967295)
			],
			[
				'name' => 'point',
				'type' => 'INT',# -2147483648 ~ 2147483647の整数
				'attr' => 'UNSIGNED NOT NULL DEFAULT 0'# 符号なしなので、範囲が変わります(0 ~ 4294967295)
			]
		],
		'pkey' => [0],# PRIMARY KEYにするカラムの番号
		'data' => [
			'cols' => [1, 2, 3],
			'values' => [
				['Rose', 4, 400],
				['SunFlower', 7, 1000],
				['Tulip', 5, 500]
			]
		]
	]
];

# 処理の呼び出し
require_once 'modelEx.php';

# 管理画面の品目一覧のテーブルHTMLを生成
include 'showData.php';

# 切断
$link->close();

$json = [
	'result' => '初期化完了',
	'html' => $html
];
echo json_encode($json);
?>