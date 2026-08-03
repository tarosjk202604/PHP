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

<?php
var_dump($pizza);
?>

<?php require './footer.php'; ?>