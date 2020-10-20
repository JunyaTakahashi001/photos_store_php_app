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
  // ログインしていない場合は、ログインページにリダイレクト
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
$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');
$comment = get_post('comment');

// POSTされたファイルデータの取得
$image = get_file('image');

// 関数を利用して商品登録を行う
if(regist_item($db, $name, $price, $stock, $status, $image, $comment)){
  set_message('商品を登録しました。');
}else {
  set_error('商品の登録に失敗しました。');
}

// 管理者ページにリダイレクト
redirect_to(ADMIN_URL);