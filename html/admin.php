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

// 関数を利用してすべてのitemデータを取得
$items = get_all_items($db);
// 商品管理ページのファイルを読み込む
include_once VIEW_PATH . '/admin_view.php';
