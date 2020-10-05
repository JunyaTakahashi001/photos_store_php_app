<?php
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// db関数ファイル読み込み
require_once MODEL_PATH . 'db.php';

// DB利用

// itemテーブルより該当商品情報取得
function get_item($db, $item_id){
  // execute時に使用する変数を格納
  $params = array('item_id'=>$item_id);
  $sql = "
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
    WHERE
      item_id = :item_id
  ";

  return fetch_query($db, $sql, $params);
}

// itemテーブルより全商品又は公開商品を取得
function get_items($db, $is_open = false){
  $sql = '
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
  ';
  if($is_open === true){
    $sql .= '
      WHERE status = 1
    ';
  }

  return fetch_all_query($db, $sql);
}

// 全itemを取得
function get_all_items($db){
  return get_items($db);
}

// 公開openの全itemを取得
function get_open_items($db){
  return get_items($db, true);
}

// 商品登録の準備
function regist_item($db, $name, $price, $stock, $status, $image){
  $filename = get_upload_filename($image);
  // バリデータを実施する
  if(validate_item($name, $price, $stock, $filename, $status) === false){
    return false;
  }
  return regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename);
}

// 商品登録のトランサクション
function regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename){
  // トランザクション開始
  $db->beginTransaction();
  // itemテーブルインサート処理とimage保存処理を呼び出し
  if(insert_item($db, $name, $price, $stock, $filename, $status) 
    && save_image($image, $filename)){
    // コミット
    $db->commit();
    return true;
  }
  // ロールバック
  $db->rollback();
  return false;
  
}

// itemテーブル登録処理
function insert_item($db, $name, $price, $stock, $filename, $status){
  $status_value = PERMITTED_ITEM_STATUSES[$status];
  // execute時に使用する変数を格納
  $params = array('name'=>$name, 'price'=>$price, 'stock'=>$stock, 'filename'=>$filename, 'status_value'=>$status_value);
  $sql = "
    INSERT INTO
      items(
        name,
        price,
        stock,
        image,
        status
      )
    VALUES(:name, :price, :stock, :filename, :status_value);
  ";

  return execute_query($db, $sql, $params);
}

// ステータス変更
function update_item_status($db, $item_id, $status){
  // execute時に使用する変数を格納
  $params = array('item_id'=>$item_id, 'status'=>$status);
  $sql = "
    UPDATE
      items
    SET
      status = :status
    WHERE
      item_id = :item_id
    LIMIT 1
  ";
  
  return execute_query($db, $sql, $params);
}

// 在庫数変更
function update_item_stock($db, $item_id, $stock){
  // execute時に使用する変数を格納
  $params = array('item_id'=>$item_id, 'stock'=>$stock);
  $sql = "
    UPDATE
      items
    SET
      stock = :stock
    WHERE
      item_id = :item_id
    LIMIT 1
  ";
  
  return execute_query($db, $sql, $params);
}

// 商品履歴追加orderテーブル
function purchase_insert_orders($db, $carts, $log){
  $params = array('order_date'=>$log, 'user_id'=>$carts[0]['user_id']);
  $sql = "
    INSERT INTO
      orders(
        order_date,
        user_id
      )
    VALUES(:order_date, :user_id);
  ";
  
  return execute_query($db, $sql, $params);
}

// 商品履歴追加order_detailテーブル
function purchase_insert_order_detail($db, $order_id, $item_id, $amount, $price){
  $params = array('order_id'=>$order_id, 'item_id'=>$item_id, 'quantity'=>$amount, 'order_price'=>$price);
  $sql = "
    INSERT INTO
      order_details(
        order_id,
        item_id,
        quantity,
        order_price
      )
    VALUES(:order_id, :item_id, :quantity, :order_price);
  ";
  return execute_query($db, $sql, $params);
}

// item削除のトランサクション
function destroy_item($db, $item_id){
  $item = get_item($db, $item_id);
  if($item === false){
    return false;
  }
  // トランザクション開始
  $db->beginTransaction();
  // 該当商品をitemテーブルとimageから削除
  if(delete_item($db, $item['item_id'])
    && delete_image($item['image'])){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
}

// itemテーブルがら該当itemを削除
function delete_item($db, $item_id){
  // execute時に使用する変数を格納
  $params = array('item_id'=>$item_id);
  $sql = "
    DELETE FROM
      items
    WHERE
      item_id = :item_id
    LIMIT 1
  ";
  
  return execute_query($db, $sql, $params);
}

// 購入数の多いitemを取得
function get_ranking($db){
  $sql = '
  SELECT
    name,
    stock,
    price,
    image,
    status,
    sum(quantity) as total_quantity
  FROM
    items
    LEFT JOIN order_details
    ON items.item_id = order_details.item_id
  GROUP BY
    items.item_id
  ORDER BY
    total_quantity DESC
  LIMIT 3;
';

  return fetch_all_query($db, $sql);
}

// 非DB

// 商品の公開ステータスが「公開」の場合trueを返す
function is_open($item){
  return $item['status'] === 1;
}

// 各引数に対してバリデーションを実施し、良否を返す
function validate_item($name, $price, $stock, $filename, $status){
  $is_valid_item_name = is_valid_item_name($name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_filename = is_valid_item_filename($filename);
  $is_valid_item_status = is_valid_item_status($status);

  return $is_valid_item_name
    && $is_valid_item_price
    && $is_valid_item_stock
    && $is_valid_item_filename
    && $is_valid_item_status;
}

// バリデーション実施
function is_valid_item_name($name){
  $is_valid = true;
  if(is_valid_length($name, ITEM_NAME_LENGTH_MIN, ITEM_NAME_LENGTH_MAX) === false){
    set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}
// バリデーション実施
function is_valid_item_price($price){
  $is_valid = true;
  if(is_positive_integer($price) === false){
    set_error('価格は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}
// バリデーション実施
function is_valid_item_stock($stock){
  $is_valid = true;
  if(is_positive_integer($stock) === false){
    set_error('在庫数は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}
// バリデーション実施
function is_valid_item_filename($filename){
  $is_valid = true;
  if($filename === ''){
    $is_valid = false;
  }
  return $is_valid;
}
// バリデーション実施
function is_valid_item_status($status){
  $is_valid = true;
  if(isset(PERMITTED_ITEM_STATUSES[$status]) === false){
    $is_valid = false;
  }
  return $is_valid;
}