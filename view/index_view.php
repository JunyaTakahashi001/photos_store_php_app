<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . $header; ?>
  

  <div class="container">
    <h1>Favorite Items...</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <div class="card-deck">
      <div class="row">
      <?php foreach($items as $item){ ?>
        <div class="col-4 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print h($item['name']); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print h(IMAGE_PATH . $item['image']); ?>">
              <figcaption>
                <?php print h(number_format($item['price'])); ?> JPY
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <!-- トークン埋め込み -->
                    <input type="hidden" name="token" value="<?=$token?>">
                    <input type="submit" value="to CART" class="btn btn-light btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                  </form>
                  <!-- 商品詳細ページリンク -->
                  <form action="index_item_detail.php" method="post">
                    <!-- トークン埋め込み -->
                    <input type="hidden" name="token" value="<?=$token?>">
                    <input type="submit" value="Item Information" class="btn btn-light btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">SOULD OUT.</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
    <!-- ランキング -->
    <h2>ranking...</h2>
    <div class="card-deck">
      <div class="row">
      <?php $counter = 1; ?>
      <?php foreach($rankings as $ranking){ ?>
        <div class="col-4 item">
          <div class="card w-auto text-center">
            <div class="card-header">
              <?php print $counter.'位 . '.h($ranking['name']); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print h(IMAGE_PATH . $ranking['image']); ?>">
              <figcaption>
                <?php print h(number_format($ranking['price'])); ?> JPY
              </figcaption>
            </figure>
          </div>
        </div>
      <?php $counter++; ?>
      <?php } ?>
      </div>
    </div>
  </div>
  
</body>
</html>