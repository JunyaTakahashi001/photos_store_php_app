<?php
// 定数ファイル読み込み
require_once '../conf/const.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイル読み込み
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
// POSTされたデータの取得
$stock = get_post('stock');

//関数を利用して在庫数の変更 
if(update_item_stock($db, $item_id, $stock)){
  // 変更が完了した場合
  set_message('在庫数を変更しました。');
} else {
  // 変更が失敗した場合
  set_error('在庫数の変更に失敗しました。');
}

// 管理者ページにリダイレクト
redirect_to(ADMIN_URL);