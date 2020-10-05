<?php
// 定数ファイル読み込み
require_once '../conf/const.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';

// ログインチェックを行うため、セッションを開始する
session_start();

// ログインチェック関数を利用
if(is_logined() === true){
  // ログインしている場合は、HOMEページにリダイレクト
  redirect_to(HOME_URL);
}

// signup_view.phpページを表示
include_once VIEW_PATH . 'signup_view.php';