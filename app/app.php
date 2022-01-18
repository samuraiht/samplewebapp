<?php
# $_POSTの数値チェック
function checkValue($val) {# 空＆0じゃない＝空　0じゃないけどキャストすると0になる
	return (empty($val) || $val == 0) && $val !== '0';
}

function sqllog($sql) {
	global $link;
	execute("INSERT INTO `debug`.`sqllog` (`sql`) VALUES('" . str_replace("'", "''", $sql) . "');");
}

function echoHTML($msg, $sql = NULL) {
	global $link;

	$response = $msg;
	if(!empty($sql)) {
# SQL実行
		if(!execute($sql)) $response = $link->error;

# 実行したSQLの記録
		sqllog($sql);
	}

# 管理画面の品目一覧のテーブルHTMLを生成
	require_once 'ControllerEx.php';

	$json = [
		'result' => $response,
		'html' => $html
	];

# PHPの連想配列をjson_encodeすると、JavaScriptのオブジェクトにそのまま使える文字列になります。
# {"result":"登録完了","html":'<tr>～</tr>'}
	echo json_encode($json);
}
?>