<?php
$reset = true;# データベース作り直しするかどうか

# データ
$data = [
	'databases' => [
		[
			'name' => 'post',
			'tables' => [
				[
					'name' => 'images',
					'columns' => [
						[
							'name' => 'id',
							'type' => 'INT',# -2147483648 ~ 2147483647の整数
							'attr' => 'UNSIGNED AUTO_INCREMENT'# 符号なしなので、範囲が変わります(0 ~ 4294967295)
						],
						[
							'name' => 'org',
							'type' => 'TEXT',# 65535バイト以下の文字列
							'attr' => 'NOT NULL'
						],
						[
							'name' => 'src',
							'type' => 'LONGTEXT',# 65535バイト以下の文字列
							'attr' => 'NOT NULL'
						],
						[
							'name' => 'alt',
							'type' => 'TEXT',# 65535バイト以下の文字列
							'attr' => NULL
						]
					],
					'pkey' => [0]# PRIMARY KEYにするカラムの番号
				],
				[
					'name' => 'posts',
					'columns' => [
						[
							'name' => 'id',
							'type' => 'INT',# -2147483648 ~ 2147483647の整数
							'attr' => 'UNSIGNED AUTO_INCREMENT'# 符号なしなので、範囲が変わります(0 ~ 4294967295)
						],
						[
							'name' => 'title',
							'type' => 'TEXT',# 65535バイト以下の文字列
							'attr' => NULL
						],
						[
							'name' => 'content',
							'type' => 'TEXT',# 65535バイト以下の文字列
							'attr' => NULL
						],
						[
							'name' => 'icon',
							'type' => 'INT',# 65535バイト以下の文字列
							'attr' => 'UNSIGNED DEFAULT NULL'
						]
					],
					'pkey' => [0]# PRIMARY KEYにするカラムの番号
				]
			]
		]
	],
	'relations' => [
		[
			'name' => 'icon01',
			'master' => [
				'database' => 'post',
				'table' => 'images',
				'column' => 'id'
			],
			'relation' => [
				'table' => 'posts',
				'column' => 'icon'
			],
			'update' => 'CASCADE',
			'delete' => 'SET NULL'
		]
	]
];

require_once '../app/ModelEx.php';# 処理の呼び出し
?>