<?php
// 定数ファイル読み込み
require_once '../conf/const.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'item.php';
// 注文履歴データに関する関数ファイル読み込み
require_once MODEL_PATH . 'order.php';

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
// トークンの生成
$token = get_csrf_token();

// orderテーブル取得（ユーザタイプにより管理者か判別）
if($user['type'] === 2){
  $orders = get_user_orders($db, $user['user_id']);
}else{
  $orders = get_user_orders_admin($db);
}

// 購入履歴ページの表示
include_once VIEW_PATH . 'order_view.php';