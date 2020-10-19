<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>購入数ランキング</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'ranking.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . $header; ?>

  <div class="container">
    <!-- ランキング -->
    <h2>Ranking...</h2>
    <div class="card-deck">
      <?php $counter = 1; ?>
      <?php foreach($rankings as $ranking){ ?>
        <div class="col-4 item">
          <div class="card w-auto text-center">
            <figure class="card-body">
              <img class="card-img" src="<?php print h(IMAGE_PATH . $ranking['image']); ?>">
              <figcaption>
                <h5 class="font-weight-bold"><?php print $counter.'位 . '.h($ranking['name']); ?></h5>
                <?php print h(number_format($ranking['price'])); ?> JPY
                <?php if($ranking['stock'] > 0){ ?>
                  <div class="tocart_btn">
                    <form action="index_add_cart.php" method="post">
                      <!-- トークン埋め込み -->
                      <input type="hidden" name="token" value="<?=$token?>">
                      <input type="submit" value="to CART" class="btn btn-light btn-block">
                      <input type="hidden" name="item_id" value="<?php print($ranking['item_id']); ?>">
                    </form>
                  </div>
                  <div class="iteminfo_btn">
                    <!-- 商品詳細ページリンク -->
                    <form action="index_item_detail.php" method="post">
                      <!-- トークン埋め込み -->
                      <input type="hidden" name="token" value="<?=$token?>">
                      <input type="submit" value="Item Information" class="btn btn-light btn-block">
                      <input type="hidden" name="item_id" value="<?php print($ranking['item_id']); ?>">
                    </form>
                  </div>
                <?php } else { ?>
                  <p class="text-danger">SOULD OUT.</p>
                <?php } ?>
              </figcaption>            
            </figure>
          </div>
        </div>
      <?php $counter++; ?>
      <?php } ?>
    </div>
</body>
</html>