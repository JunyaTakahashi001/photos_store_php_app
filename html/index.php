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

// ページネーション
// 全アイテム数を取得
$all_item_num_array = get_open_item_count($db);
$all_item_num = $all_item_num_array['all_item_count'];

// ページ数を算出
$pagenation = $all_item_num / PAGENATION_LIMIT;
$pagenation = ceil($all_item_num / PAGENATION_LIMIT);

// GETで現在のページ数を取得する（未入力の場合は1を挿入）
if (isset($_GET['page'])) {
	$page = (int)$_GET['page'];
} else {
	$page = 1;
}

// スタートのポジションを計算する
if ($page > 1) {
	// 例：２ページ目の場合は、『(2 × 8) - 8 = 8』
	$start = ($page * PAGENATION_LIMIT) - PAGENATION_LIMIT;
} else {
	$start = 0;
}

// 並べ替えに沿ったitemを取得
if(isset($_GET['sort'])){
    $sort = get_get("sort");
    $items = get_sort_open_items($db, $sort, $start);
  } else {
    $sort = 'created_desc';
    $items = get_sort_open_items($db, $sort, $start);
  }

// 楽天トラベルAPI連携
$rests = gurunavi_search_restlist_v3();
// 配列の階層変更
$rests = $rests[0]['Ranking']['hotels'];

// ビューの読み込み
include_once VIEW_PATH . 'index_view.php';