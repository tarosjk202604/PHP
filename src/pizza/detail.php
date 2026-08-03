<?php

// データベース接続
require './dbconnect.php';

if (isset($db)) {

  // リクエスト方法: GET, idパラメーターが存在している
  if (
    $_SERVER['REQUEST_METHOD'] === 'GET' &&
    isset($_GET['id'])
  ) {
    // うまくいった場合
    $stmt = $db->prepare('SELECT * FROM pizzas WHERE id = ?');
    $stmt->bindValue(1, $_GET['id']);
    $result = $stmt->execute();

    if ($result) {
      $pizza = $stmt->fetch(); //１件分のデータを取得
    } else {
      // ダメな場合
      header('location:index.php');
      exit;
    }
  } else {
    // ダメな場合
    header('location:index.php');
    exit;
  }
}

?>
<?php require './header.php'; ?>

<div class="container">

  <h1 class="text-center h3">Pizza Detail</h1>

  <?php if ($pizza): ?>

    <div class="row justify-content-center">
      <div class="col-md-6">
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
            <p class="card-text">シェフ: <?= $pizza['chef_name']; ?></p>
            <p class="card-text">登録日: <?= $pizza['created_at']; ?></p>
          </div>
          <div class="card-footer text-end">
            <button class="btn btn-danger">削除</button>
          </div>
        </div>
      </div>
    </div>

  <?php else:  ?>

    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
      </symbol>
    </svg>
    <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:">
        <use xlink:href="#exclamation-triangle-fill" />
      </svg>
      <div>
        ピザのデータが存在しません。
      </div>
    </div>

  <?php endif; ?>

</div>

<?php require './footer.php'; ?>