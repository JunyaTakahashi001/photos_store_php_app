<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 汎用関数ファイルを読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'user.php';

// ログインチェックを行うため、セッションを開始する
session_start();

// ログインチェック用関数を利用
if(is_logined() === true){
  // ログインしてる場合はHOMEページにリダイレクト
  redirect_to(HOME_URL);
}

// postされたデータを取得
$name = get_post('name');
$password = get_post('password');

// PDOを取得
$db = get_db_connect();

// 関数を利用してログイン
$user = login_as($db, $name, $password);
if( $user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

// ログインメッセージセット
set_message('ログインしました。');
// ユーザーTypeを取得し、管理者の場合管理者ページにリダイレクト
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(ADMIN_URL);
}
// HOMEにリダイレクト
redirect_to(HOME_URL);