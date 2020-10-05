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
$changes_to = get_post('changes_to');

// 変更するステータスが"open"の場合
if($changes_to === 'open'){
　// 関数を利用してステータスの変更処理
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  set_message('ステータスを変更しました。');
// 変更するステータスが"close"の場合
}else if($changes_to === 'close'){
　// 関数を利用してステータスの変更処理
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  set_message('ステータスを変更しました。');
// 変更するステータスがその他の場合
}else {
　// set_errorにcommentを代入
  set_error('不正なリクエストです。');
}

// 管理者ページにリダイレクト
redirect_to(ADMIN_URL);