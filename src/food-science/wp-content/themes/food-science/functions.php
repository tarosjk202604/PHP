<?php

/**
 * titleタグを出力する
 */
add_theme_support('title-tag');

/**
 * アイキャッチ画像を使用可能にする
 */
add_theme_support('post-thumbnails');

/**
 * カスタムメニュー機能を使用可能にする
 */
add_theme_support('menus');

/**
 * titleの区切り文字を変更する
 */
add_filter('document_title_separator', 'my_document_title_separator');
function my_document_title_separator(string $separator): string
{
  $separator = '|';
  return $separator;
}


function my_dump(mixed $data): void
{
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
}


/**
 * Contact Form 7の時は整形機能をOFFにする
 */
add_filter('wpcf7_autop_or_not', 'my_wpcf7_autop');
function my_wpcf7_autop()
{
  return false;
}
