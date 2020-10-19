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

// POSTされた検索ワードを取得
$search_word = get_post('search_word');

// 空白チェック
if($search_word === ''){
    set_error('検索する文字を入力してください。');
}else{
    // あいまい検索に変更
    $search_word = '%' . $search_word . '%';

    // dbを検索
    $search_items = get_search_item($db, $search_word);

    // 該当なしチェック
    if(empty($search_items)){
        set_error('検索結果：該当する商品はありません。');
    } 
}



// ビューの読み込み
include_once VIEW_PATH . 'index_search_view.php';