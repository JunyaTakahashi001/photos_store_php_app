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

// POSTされたitemを取得
$item_id = get_post('item_id');

// 該当商品情報を取得
$item = get_item($db, $item_id);

// ビューの読み込み
include_once VIEW_PATH . 'index_item_detail_view.php';