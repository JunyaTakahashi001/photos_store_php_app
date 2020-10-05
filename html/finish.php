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
require_once MODEL_PATH . 'cart.php';

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

// get_user_carts関数を利用して該当ユーザーのカート情報を取得
$carts = get_user_carts($db, $user['user_id']);

// purchase_carts関数を利用し購入処理
if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} 

// 関数を利用して合計金額を取得
$total_price = sum_carts($carts);

// 購入完了ページの表示
include_once '../view/finish_view.php';