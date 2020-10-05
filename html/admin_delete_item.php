<?php
// 定数関数ファイルの読み込み
require_once '../conf/const.php';
// 汎用関数ファイルの読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルの読み込み
require_once MODEL_PATH . 'item.php';

// ログインチェックを行うため、セッションを開始する
session_start();

// ログイン用関数を利用
if(is_logined() === false){
  // ログインしていない場合はログインページにリダイレクト
  redirect_to(LOGIN_URL);
}

// PODを取得
$db = get_db_connect();

// PODを利用してログインユーザのデータを取得
$user = get_login_user($db);

// is_admin関数を利用してユーザーTypeの取得
if(is_admin($user) === false){
  // 管理者でなければ、ログイン画面にリダイレクト
  redirect_to(LOGIN_URL);
}

// POSTされたデータの取得
$item_id = get_post('item_id');

// 関数を利用してデータベースの処理
if(destroy_item($db, $item_id) === true){
  set_message('商品を削除しました。');
} else {
  set_error('商品削除に失敗しました。');
}

// 管理ページにリダイレクト
redirect_to(ADMIN_URL);