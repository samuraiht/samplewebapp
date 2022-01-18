<?php
$reset = true;# データベース作り直しするかどうか

# データ
$data = [
	[
		'name' => 'debug',
		'tables' => [
			[
				'name' => 'sqllog',
				'columns' => [
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
			]
		]
	]
];

require_once 'ModelEx.php';# 処理の呼び出し
?>