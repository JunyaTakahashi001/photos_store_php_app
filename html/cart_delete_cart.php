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

// POSTされたデータを取得
$cart_id = get_post('cart_id');

// 関数を利用してCartの商品を削除する
if(delete_cart($db, $cart_id)){
  set_message('カートを削除しました。');
} else {
  set_error('カートの削除に失敗しました。');
}

// cartページにリダイレクト
redirect_to(CART_URL);