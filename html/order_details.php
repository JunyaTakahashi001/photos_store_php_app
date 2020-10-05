<?php
// 定数ファイル読み込み
require_once '../conf/const.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'item.php';
// cartデータに関する関数ファイル読み込み
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
// POST受取り処理
$order_id = get_post('order_id');

// トークンの生成
$token = get_csrf_token();

// orderテーブル取得
$order_detail_top = get_order_detail_top($db, $order_id);

// order_detailsテーブル取得
$order_details = get_order_details($db, $order_id);

// 購入履歴詳細ページを表示
include_once VIEW_PATH . 'order_details_view.php';