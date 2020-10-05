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

// PDOを取得
$db = get_db_connect();

// PDOを利用してログインユーザのデータを取得
$user = get_login_user($db);

// 商品一覧用の商品データを取得
$items = get_open_items($db);

// ビューの読み込み
include_once VIEW_PATH . 'index_view.php';