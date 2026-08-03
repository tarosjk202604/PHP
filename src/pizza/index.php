<?php

// データベース接続
require './dbconnect.php';

if (isset($db)) {
  $sql = 'SELECT id, toppings, pizza_name, image FROM pizzas';
  $result = $db->query($sql);
}

?>
<?php require './header.php'; ?>

<?php if (isset($result)): ?>
  <!-- パターン1. １件ずつデータを取り出す -->
  <?php //while ($pizza = $result->fetch()): 
  ?>
  <?php //var_dump($pizza); 
  ?>
  <?php //endwhile; 
  ?>

  <!-- パターン2. 全件まとめてデータを取り出す -->
  <?php
  $pizzas = $result->fetchAll();
  ?>

  <div class="container">
    <h2 class="text-center my-5">Our Special Pizzas</h2>

    <div class="row">
      <?php foreach ($pizzas as $pizza): ?>
        <div class="col-md-4 mb-4">

          <div class="card">
            <?php
            $pizza_img = '';
            if (empty($pizza['image'])) {
              //画像データがない
              $pizza_img = 'default.png';
            } else {
              // 画像データがある場合
              $pizza_img = $pizza['image'];
            }
            ?>
            <img src="uploads/<?= $pizza_img; ?>" alt="" class="card-img-top">
            <div class="card-body">
              <h3 class="h4 card-title"><?= $pizza['pizza_name']; ?></h3>
              <p class="card-text"><?= $pizza['toppings']; ?></p>
              <a href="detail.php?id=<?= $pizza['id']; ?>" class="btn btn-primary">詳細</a>
            </div>
          </div>

        </div>
      <?php endforeach; ?>

    </div>
  </div>

<?php endif; ?>

<?php require './footer.php'; ?>