<?php

// データベース接続
require './dbconnect.php';

// エラーメッセージ用変数
// $error = '';
$errors = [
  'chef-name'   => '',
  'pizza-name'  => '',
  'toppings'    => '',
  'pizza-img'   => '',
];

// 入力値の再反映用変数
$chef_name = '';
$pizza_name = '';
$toppings = '';

// フォームデータ送信後の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

  // 1. 必須入力チェック
  if (empty($_POST['chef-name'])) {
    $errors['chef-name'] = 'シェフの名前が入力されていません';
  } else {
    // 入力があった場合、書式チェックを行う
    // 日本語＋英数字のみ, 制御文字は含まず
    if (!preg_match('/^([^\x01-\x7E]|[\da-zA-Z,\- ])+$/', $_POST['chef-name'])) {
      $errors['chef-name'] = '日本語、英数字のみ有効です。記号等は使用できません';
    }

    // 入力値の再反映
    $chef_name = $_POST['chef-name'];
  }

  if (empty($_POST['pizza-name'])) {
    $errors['pizza-name'] = 'ピザの名前が入力されていません';
  } else {
    // 入力があった場合、書式チェックを行う
    // 日本語＋英数字のみ, 制御文字は含まず
    if (!preg_match('/^([^\x01-\x7E]|[\da-zA-Z,\- ])+$/', $_POST['pizza-name'])) {
      $errors['pizza-name'] = '日本語、英数字のみ有効です。記号等は使用できません';
    }

    // 入力値の再反映
    $pizza_name = $_POST['pizza-name'];
  }

  if (empty($_POST['toppings'])) {
    $errors['toppings'] = 'トッピングが入力されていません';
  } else {
    // 入力値の再反映
    $toppings = $_POST['toppings'];
  }

  // 画像ファイルのチェック
  // var_dump($_FILES['pizza-img']);
  if (
    $_FILES['pizza-img']['tmp_name'] !== '' && //アップロードの確認
    $_FILES['pizza-img']['error'] === 0 && //エラーなし
    !array_filter($errors) //入力系にエラーがなかった場合
  ) {
    // echo 'アップロードがありました';

    // 画像かどうかのチェック type を確認する
    // 用意した配列の中にアップロードした画像の type があるかチェック
    $ok_types = ['image/jpeg', 'image/png', 'image/webp'];

    if (in_array($_FILES['pizza-img']['type'], $ok_types)) {
      // ファイル名の作成
      $upload_img_name = $_FILES['pizza-img']['name'];

      // ファイル移動
      $upload_success = move_uploaded_file($_FILES['pizza-img']['tmp_name'], 'uploads/' . $upload_img_name);

      if (!$upload_success) {
        $errors['pizza-img'] = '画像のアップロードに失敗しました';
      }
    } else {
      $errors['pizza-img'] = '画像は JPEG, PNG, WEBP のいずれかの形式を選んでください。';
    }
  }

  // エラー最終チェック
  // var_dump(array_filter($errors));
  if (!array_filter($errors)) {
    // 画像のアップロードチェック
    $is_image_uploaded = $_FILES['pizza-img']['tmp_name'];

    // データベースへの登録
    if ($is_image_uploaded) {
      $stmt = $db->prepare('INSERT INTO pizzas (chef_name, pizza_name, toppings, image) VALUES(?,?,?,?)');
    } else {
      $stmt = $db->prepare('INSERT INTO pizzas (chef_name, pizza_name, toppings) VALUES(?,?,?)');
    }
    $stmt->bindValue(1, $_POST['chef-name']);
    $stmt->bindValue(2, $_POST['pizza-name']);
    $stmt->bindValue(3, $_POST['toppings']);
    if ($is_image_uploaded) {
      $stmt->bindValue(4, $_FILES['pizza-img']['name']);
    }

    $result = $stmt->execute();

    if ($result) {
      // エラーなしの場合、index.phpにリダイレクト
      header('location: index.php');
      exit;
    }
  }
} //if
?>
<?php require './header.php'; ?>

<div class="container">
  <h1 class="my-5 h4 text-center">ピザの追加</h1>

  <div class="row justify-content-center">
    <div class="col-md-8 bg-white p-4 rounded">

      <form action="add.php" method="post" enctype="multipart/form-data">
        <!-- シェフの名前 -->
        <div class="mb-3">
          <label for="chef-name" class="form-label">シェフの名前</label>
          <input type="text" class="form-control" id="chef-name" name="chef-name" value="<?= htmlspecialchars($chef_name); ?>">
          <p class="form-text text-danger"><?= $errors['chef-name']; ?></p>
        </div>
        <!-- ピザの名前 -->
        <div class="mb-3">
          <label for="pizza-name" class="form-label">ピザの名前</label>
          <input type="text" class="form-control" id="pizza-name" name="pizza-name" value="<?= htmlspecialchars($pizza_name); ?>">
          <p class="form-text text-danger"><?= $errors['pizza-name']; ?></p>
        </div>
        <!-- トッピング -->
        <div class="mb-3">
          <label for="toppings" class="form-label">トッピング</label>
          <input type="text" class="form-control" id="toppings" name="toppings" value="<?= htmlspecialchars($toppings); ?>">
          <p class="form-text text-danger"><?= $errors['toppings']; ?></p>
        </div>
        <!-- ピザの画像 -->
        <div class="mb-3">
          <label for="pizza-img" class="form-label">ピザの画像</label>
          <input type="file" class="form-control" id="pizza-img" name="pizza-img">
          <p class="form-text text-danger"><?= $errors['pizza-img']; ?></p>
        </div>

        <!-- 送信ボタン -->
        <div class="text-center">
          <button class="btn btn-primary" name="submit" value="1">登録する</button>
        </div>
      </form>

    </div>
  </div>
</div>


<?php require './footer.php'; ?>