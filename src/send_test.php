<?php
// 日本語環境の設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

echo "<h1>メール送信テスト（デバッグ版）</h1>";

// 1. PHPの現在の設定値を確認して表示する
$sendmail_path = ini_get('sendmail_path');
echo "<h2>1. PHP設定値の確認</h2>";
echo "現在の <code>sendmail_path</code> の設定値: <strong style='color: blue;'>" . htmlspecialchars($sendmail_path) . "</strong><br>";

// 2. メール送信処理の実行
echo "<h2>2. メール送信の実行</h2>";

$to      = "test-user@example.local";
$subject = "【テスト】会員登録の確認";
$message = "Docker上のPHP環境から、Mailpitへのメール送信テストです。\n\n"
  . "リンクテスト： http://localhost:8080/confirm.php?token=xyz123";
$headers = "From: system@project-a.local" . "\r\n"
  . "Reply-To: support@project-a.local";

// PHPのエラーレポートを一時的に全て有効にする
error_reporting(E_ALL);
ini_set('display_errors', '1');

// メール送信を実行し、返り値とエラーを検証する
try {
  $result = mb_send_mail($to, $subject, $message, $headers);
  if ($result) {
    echo "<p style='color: green; font-weight: bold;'>[成功] メールを送信しました！</p>";
    echo "<p><a href='http://localhost:8025' target='_blank'>Mailpitの管理画面を開いて確認する (http://localhost:8025)</a></p>";
  } else {
    echo "<p style='color: red; font-weight: bold;'>[失敗] mb_send_mail() が false を返しました。</p>";

    // 直近のPHPエラーを取得して表示
    $last_error = error_get_last();
    if ($last_error) {
      echo "エラーメッセージ: " . $last_error['message'] . "<br>";
    } else {
      echo "PHPシステムからのエラーメッセージはありません。msmtpコマンド自体の実行エラーの可能性があります。<br>";
    }
  }
} catch (Exception $e) {
  echo "<p style='color: red; font-weight: bold;'>例外発生: " . $e->getMessage() . "</p>";
}
