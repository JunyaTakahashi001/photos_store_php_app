<?php
// 定数ファイルを読み込み
require_once '../conf/const.php';
// 汎用関数ファイルを読み込み
require_once MODEL_PATH . 'functions.php';
// userデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'user.php';
// itemデータに関する関数ファイルを読み込み
require_once MODEL_PATH . 'item.php';

// ログインチェックを行うため、セッションを開始する
session_start();

// ログイン用関数を利用
if(is_logined() === false){
    // ログインしていない場合のヘッダー
    $header = 'templates/header.php';
}else{
    // ログインしている場合のヘッダー
    $header = 'templates/header_logined.php';
}


// PDOを取得
$db = get_db_connect();

// PDOを利用してログインユーザのデータを取得
$user = get_login_user($db);

// 購入数ランキングを取得
$rankings = get_ranking($db, RANKING_LIMIT);

// ビューの読み込み
include_once VIEW_PATH . 'ranking_view.php';