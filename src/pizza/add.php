<?php
// エラーメッセージ用変数
// $error = '';
$errors = [
  'chef-name' => '',
  'pizza-name' => '',
  'toppings' => '',
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
}
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
          <input type="text" class="form-control" id="chef-name" name="chef-name" value="<?= $chef_name; ?>">
          <p class="form-text text-danger"><?= $errors['chef-name']; ?></p>
        </div>
        <!-- ピザの名前 -->
        <div class="mb-3">
          <label for="pizza-name" class="form-label">ピザの名前</label>
          <input type="text" class="form-control" id="pizza-name" name="pizza-name">
          <p class="form-text text-danger"><?= $errors['pizza-name']; ?></p>
        </div>
        <!-- トッピング -->
        <div class="mb-3">
          <label for="toppings" class="form-label">トッピング</label>
          <input type="text" class="form-control" id="toppings" name="toppings">
          <p class="form-text text-danger"><?= $errors['toppings']; ?></p>
        </div>
        <!-- ピザの画像 -->
        <div class="mb-3">
          <label for="pizza-img" class="form-label">ピザの画像</label>
          <input type="file" class="form-control" id="pizza-img" name="pizza-img">
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