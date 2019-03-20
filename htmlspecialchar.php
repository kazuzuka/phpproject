<?php
ini_set('display_errors', "On");
// htmlspecialchars()関数のサンプルプログラム

// htmlタグを含めた文字列を入力
$str = '<h2>php勉強中です</h2>';

// htmlspecialchars()を使わない場合
print $str;

// htmlspecialchars()を使う場合
print htmlspecialchars($str, ENT_QUOTES, 'UTF-8');