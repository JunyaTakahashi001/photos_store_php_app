<?php
// 定数を定義する

// 関数ファイルディレクトリパス
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');
// 画面表示ファイルディレクトリパス
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');

// 画像ファイルディレクトリパス
define('IMAGE_PATH', '/assets/images/');
// cssファイルディレクトリパス
define('STYLESHEET_PATH', '/assets/css/');
// 画像ファイルディレクトリ
define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' );


// データベース設定
define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET', 'utf8');


// 画面表示ファイルアドレス
define('SIGNUP_URL', '/signup.php');
define('LOGIN_URL', '/login.php');
define('LOGOUT_URL', '/logout.php');
define('HOME_URL', '/index.php');
define('CART_URL', '/cart.php');
define('FINISH_URL', '/finish.php');
define('ADMIN_URL', '/admin.php');
define('ORDER_URL', '/order.php');
define('RANKING_URL', '/ranking.php');

// 正規表現の設定
// 英数字
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
// 偶数
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');

// ユーザー登録設定
define('USER_NAME_LENGTH_MIN', 6);
define('USER_NAME_LENGTH_MAX', 100);
define('USER_PASSWORD_LENGTH_MIN', 6);
define('USER_PASSWORD_LENGTH_MAX', 100);

// ユーザーType設定
define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_NORMAL', 2);

// 商品設定
define('ITEM_NAME_LENGTH_MIN', 1);
define('ITEM_NAME_LENGTH_MAX', 100);
define('ITEM_COMMENT_LENGTH_MAX', 1000);

// 商品公開ステータス設定
define('ITEM_STATUS_OPEN', 1);
define('ITEM_STATUS_CLOSE', 0);

// 許可する商品公開ステータス設定
define('PERMITTED_ITEM_STATUSES', array(
  'open' => 1,
  'close' => 0,
));

// 許可する画像拡張子設定
define('PERMITTED_IMAGE_TYPES', array(
  IMAGETYPE_JPEG => 'jpg',
  IMAGETYPE_PNG => 'png',
));

// 購入数ランキング取得数設定
define('RANKING_LIMIT', 3);

// 1ページに表示するitem数を取得
define('PAGENATION_LIMIT', 6);