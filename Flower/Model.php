<?php
# データベース作り直しするかどうか
$reset = true;

# データ
$data = [
	[
		'name' => 'flower',
		'tables' => [
			[
				'name' => 'flower',
				'columns' => [
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
					],
					[
						'name' => 'shipping',
						'type' => 'INT',# -2147483648 ~ 2147483647の整数
						'attr' => 'UNSIGNED NOT NULL DEFAULT 0'# 符号なしなので、範囲が変わります(0 ~ 4294967295)
					]
				],
				'pkey' => [0],# PRIMARY KEYにするカラムの番号
				'data' => [
					'columns' => [1, 2, 3],
					'values' => [
						['Rose', 4, 400],
						['SunFlower', 7, 300],
						['Tulip', 5, 200]
					]
				]
			]
		]
	]
];

require_once '../app/ModelEx.php';# 処理の呼び出し
?>