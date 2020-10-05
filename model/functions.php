<?php
// 汎用関数ファイル

// 変数、配列情報出力
function dd($var){
  var_dump($var);
  exit();
}

// 引数のURLにリダイレクト
function redirect_to($url){
  header('Location: ' . $url);
  exit;
}

// GETされた変数の取得（送信内容がURLに渡されます）
function get_get($name){
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}

// POSTされた$nameの取得
function get_post($name){
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}

// POSTされたファイルを取得
function get_file($name){
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}

// セッション$nameを取得
function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}

// セッション$nameを保存
function set_session($name, $value){
  $_SESSION[$name] = $value;
}

// セッション$errorを保存
function set_error($error){
  $_SESSION['__errors'][] = $error;
}

// セッション$errorsを取得
function get_errors(){
  $errors = get_session('__errors');
  // $errorsの空チェック
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}

// セッション$errorsの空、個数が0かチェック
function has_error(){
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

// セッション$messagesを保存
function set_message($message){
  $_SESSION['__messages'][] = $message;
}

// セッション$messagesを取得
function get_messages(){
  $messages = get_session('__messages');
  // $messagesの空チェック
  if($messages === ''){
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}

// ログイン済みの場合trueを返す
function is_logined(){
  return get_session('user_id') !== '';
}

// アップロードされた画像のファイルネームを取得
function get_upload_filename($file){
  if(is_valid_upload_image($file) === false){
    return '';
  }
  // 画像ファイルが判別する（画像ファイルの拡張子別の定数を返す）
  $mimetype = exif_imagetype($file['tmp_name']);
  // 数字の定数を拡張子に変更している
  $ext = PERMITTED_IMAGE_TYPES[$mimetype];
  return get_random_string() . '.' . $ext;
}

function get_random_string($length = 20){
  // ユニークIDをハッシュ化して使用する
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

function save_image($image, $filename){
  // 一時的に保存されている画像をimagesに正式に保存する
  return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}

// 商品削除するときに画像も削除する
function delete_image($filename){
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
    return true;
  }
  return false;
  
}


// 文字列の最大最小lengthを検査
function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  // 文字列の長さを取得
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

// 英数字検査の関数を呼び出し
function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

// 偶数検査の関数を呼び出し
function is_positive_integer($string){
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

// 正規表現とマッチするか検索
function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}

// 正式にPOSTされたものか判別
function is_valid_upload_image($image){
  if(is_uploaded_file($image['tmp_name']) === false){
    set_error('ファイル形式が不正です。');
    return false;
  }
  $mimetype = exif_imagetype($image['tmp_name']);
  if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}

// 文字列のエスケープ処理
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// トークンの生成
function get_csrf_token(){
  // get_random_string()はユーザー定義関数。
  $token = get_random_string(30);
  // set_session()はユーザー定義関数。
  set_session('csrf_token', $token);
  return $token;
}

// トークンのチェック
function is_valid_csrf_token($token){
  if($token === '') {
    return false;
  }
  // get_session()はユーザー定義関数
  return $token === get_session('csrf_token');
}