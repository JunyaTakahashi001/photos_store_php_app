<?php
// 定数ファイル読み込み
require_once '../conf/const.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイル読み込み
require_once MODEL_PATH . 'user.php';

// ログインチェックを行うため、セッションを開始する
session_start();

// ログインチェック用関数を利用
if(is_logined() === true){
  // ログインしてる場合はHOMEページにリダイレクト
  redirect_to(HOME_URL);
}

// POSTされたデータを取得
$name = get_post('name');
$password = get_post('password');
$password_confirmation = get_post('password_confirmation');

// PODを取得
$db = get_db_connect();

// 登録処理
try{
  // 関数を利用してデータベースに登録処理
  $result = regist_user($db, $name, $password, $password_confirmation);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}

// 完了メッセージ
set_message('ユーザー登録が完了しました。');
// データベースと照合
login_as($db, $name, $password);
// HOMEページにリダイレクト
redirect_to(HOME_URL);