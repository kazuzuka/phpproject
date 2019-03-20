<?php
ini_set('display_errors', "On");
// htmlspecialchars()関数のサンプルプログラム(自作関数を使用）

// htmlタグを含めた文字列を入力
$str = '<h2>php勉強中です</h2>';


function h($s) {
    echo htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

?>

<p>Hello, <?php h($str); ?>!</p>