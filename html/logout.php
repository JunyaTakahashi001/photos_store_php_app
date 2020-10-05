<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 汎用関数ファイルを読み込み
require_once MODEL_PATH . 'functions.php';

// セッション開始
session_start();
// 変数初期化
$_SESSION = array();
// 現在のセッションクッキー情報を配列で返す
$params = session_get_cookie_params();
// クッキーの定義
setcookie(session_name(), '', time() - 42000,
  $params["path"], 
  $params["domain"],
  $params["secure"], 
  $params["httponly"]
);
// セッション終了
session_destroy();

// ログインページにリダイレクト
redirect_to(LOGIN_URL);