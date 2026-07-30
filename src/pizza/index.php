<?php

// データベースの接続
try {
  $dsn = 'mysql:host=db;dbname=interplan_pizza;charset=utf8';
  $user = 'pizzataro';
  $pass = 'C!Gw8zhn(ZQxZw)S';
  $option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //PDO専用のエラーを受け取る
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //データを連想配列で受け取る
  ];

  $db = new PDO($dsn, $user, $pass, $option);
} catch (PDOException $e) {
  echo 'データベースの接続でエラーが発生しました。' . $e->getMessage();
}

if (isset($db)) {
  $sql = 'SELECT id, chef_name, pizza_name FROM pizzas';
  $result = $db->query($sql);
}

?>
<?php require './header.php'; ?>

<?php if (isset($result)): ?>
  <?php while ($pizza = $result->fetch()): ?>
    <?php var_dump($pizza); ?>
  <?php endwhile; ?>
<?php endif; ?>

<?php require './footer.php'; ?>