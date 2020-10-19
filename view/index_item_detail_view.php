<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品説明</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index_item_detail.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . $header; ?>
  

  <div class="container">
    <h2>Description...</h2>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    
    <div row>
      <div class="container">
        <div class="row">
          <div class="col-md-6 img">
            <img class="card-img" src="<?php print h(IMAGE_PATH . $item['image']); ?>">
          </div>
          <div class="col-md-6 description">
            <h3 class="font-weight-bold"><?php print h($item['name']); ?></h3>
            <p class="w_break"><?php print h($item['comment']); ?></P>
            <figcaption>
              <?php print h(number_format($item['price'])); ?> JPY
                <?php if($item['stock'] > 0){ ?>
                <div class="tocart_btn">
                  <form action="index_add_cart.php" method="post">
                    <!-- トークン埋め込み -->
                    <input type="hidden" name="token" value="<?=$token?>">
                    <input type="submit" value="to CART" class="btn btn-light btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                  </form>
                </div>
              <?php } else { ?>
                <p class="text-danger">SOULD OUT.</p>
              <?php } ?>
            </figcaption>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>