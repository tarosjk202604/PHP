<?php
require_once './parts.html';
require_once './parts.html'; //２回目以降は無視される
// include('./parts.html');
?>
<?php

function my_dump(mixed $data)
{
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
}

echo 'Hello, PHP Basic', '今日は曇りです';

?>
<p>今日の天気は<?php echo '曇り'; ?>です。</p>
<p>今日の天気は<?= '曇り'; ?>です。</p>
<?php

// 変数定義
$name = 'ケンシロウ<br>';
echo $name;

$name = 'ラオウ';
echo $name;

// 定数定義
define('NAME', 'トキ');

echo NAME;

echo '<br>';

// NAME = 'ケンシロウ';
/* あいうえお */
# これもコメントアウト
?>
<br>
<?php
$strOne = '今日は';
$strTwo = '良い天気です';
echo $strOne . $strTwo;
?>
<br>
<?php
// 変数の補完
echo '今日は、$strTwo です。';
echo "今日は、{$strTwo}です。";
?>
<br>
<?php
echo "私の流派は北斗神拳です\n";
echo "私の流派は南斗聖拳です";
?>
<br>
<?php
// Nowdoc (シングルクォーテーションの代わり)
// 複数行になるテキストの対処法
echo <<<'HOTDOG'
あいうえお<br>
かきくけこ<br>
さしすせそ{$strOne}<br>
HOTDOG;

// HEREDOC(ダブルクォテーションの代わり)
echo <<<HEREDOC
  "あいうえお"<br>
  かきくけこ<br>
  さしすせそ{$strOne}<br>
HEREDOC;

?>

<br>
<?php
$strcount = 'ドラゴンボール⭐️';
echo strlen($strcount);
echo mb_strlen($strcount);

$float1 = 12.34;
$float2 = 12.0 + 0.34;

var_dump($float1 === $float2);
?>

<br>

<?php
$num = 5;
// echo $num++;
echo ++$num; //$num = $num + 1
echo '<br>';
echo $num;
?>

<br>

<?php

$fruits = ['いちご', 'メロン', 'なし'];
echo $fruits[1]; // 配列は0始まり

my_dump($fruits);

$ages = [20, 30, 40, 50];
$ages[] = 60; // 末尾にデータを追加
my_dump($ages);

// 連想配列
$ages = [
  'kenshiro' => 18,
  'bat' => 10,
  'rin' => 8,
];
echo $ages['kenshiro'];

?>

<br>

<?php
// 多次元配列
$machines = [
  ['name' => 'ファミリーコンピューター', 'brand' => '任天堂', 'year' => 1983],
  ['name' => 'メガドライブ', 'brand' => 'セガ', 'year' => 1988],
  ['name' => 'ネオジオ', 'brand' => 'SNK', 'year' => 1990],
];

?>
<br>
<?php
// 繰り返し処理
for ($i = 0; $i < count($fruits); $i++) {
  echo $fruits[$i] . '<br>';
  echo "{$fruits[$i]}<br>";
}

// foreach文
// $machines = [
//   ['name' => 'ファミリーコンピューター', 'brand' => '任天堂', 'year' => 1983],
//   ['name' => 'メガドライブ', 'brand' => 'セガ', 'year' => 1988],
//   ['name' => 'ネオジオ', 'brand' => 'SNK', 'year' => 1990],
// ];
foreach ($machines as $key => $machine) {
  $key += 1;
  echo "{$key}{$machine['name']} - {$machine['brand']} ( {$machine['year']} ) <br>";
}
?>

<p>foreachとHTML</p>
<ul>
  <?php foreach ($machines as $machine) : ?>
    <li><?= $machine['name']; ?> - <?= $machine['brand']; ?> (<?= $machine['year']; ?>)</li>
  <?php endforeach; ?>
</ul>

<?php

$fruits = [
  ['name' => 'りんご', 'price' => 100],
  ['name' => 'なし', 'price' => 120],
  ['name' => 'みかん', 'price' => 90],
];

foreach ($fruits as $fruit) {
  if ($fruit['price'] >= 110) {
    // break;
    continue;
  }
  echo "{$fruit['name']} {$fruit['price']}円 <br>";
}
?>

<br>

<?php
/*
if($day === 'Monday') {

}elseif($day === 'Tuesday') {

}...
 */
// 曜日によって営業時間を表す
// $day = 'Wednesday';
$day = date('D');
my_dump($day);
$openHours = '';
switch ($day) {
  case 'Mon':
  case 'Wed':
  case 'Thu':
    $openHours = '9:00 - 18:00';
    break;
  case 'Tue':
    $openHours = '定休日';
    break;
    // case 'Wednesday':
    //   $openHours = '9:00 - 18:00';
    //   break;
    // case 'Thursday':
    //   $openHours = '9:00 - 18:00';
    //   break;
}

?>
<p>今日の営業時間: <?= $openHours; ?></p>

<?php
// PHPの設定を表示する関数
// phpinfo();
?>

<br>

<?php
// 関数
/**
 * PHPDoc 価格に「円」を付けて返す
 * 
 * 詳細説明
 * @param int $price 価格の数値
 * @param 型 引数名 説明
 * 
 * @return string 「円」を付けた価格の文字
 */
function formatYenPrice(int $price = 500): string
{
  return $price . '円';
}


echo formatYenPrice(1000);


$weather = '晴れ';

function todaysWeather()
{
  global $weather;
  echo "今日の天気は{$weather}";

  // my_dump($_SERVER); //$_SERVER スーパーグローバル変数
}
todaysWeather();

?>

<br>

<?php
// スーパーグローバル変数 $_GET - URLパラメーターを受け取る変数
my_dump($_GET);
$_GET['name'];

?>

<?php
// フォーム

my_dump($_POST);
// my_dump($_SERVER);

// フォームからデータが送信された場合の処理
// 1. 送信方法がPOSTであることをチェック
// 2. ボタンから送信される値が含まれていることをチェック
$sent_message = '';
if (
  $_SERVER['REQUEST_METHOD'] === 'POST' &&
  isset($_POST['submit'])
) {
  echo 'フォームからデータが送信されました';

  // メール送信の内容
  $to = 'admin@php-basic.local';
  $subject = 'お問い合わせフォームから送信がありました';
  $message = <<<MSG
      サイトからお問い合わせがありました。
      内容は以下の通りです。

      メール: {$_POST['email']}
      名前: {$_POST['fullname']}
  MSG;
  $headers = [
    'From' => 'PHP Basic <noreply@php-basic.local>',
    'Reply-To' => 'info@php-basic.local',
  ];

  // 実際のメール送信
  $success = mb_send_mail($to, $subject, $message, $headers);


  if ($success) {
    $sent_message = 'メールが送信されました';
  } else {
    $sent_message = 'メールの送信に失敗しました';
  }
}
?>
<!-- 
action: データの送信先
method: 送信方法(get, post)
-->
<p>
  <?= $sent_message; ?>
</p>
<form action="index.php" method="post">
  <input type="text" name="email"><br>
  <input type="text" name="fullname"><br>
  <button type="submit" name="submit" value="1">送信</button>
</form>