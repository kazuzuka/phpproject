<?php
ini_set('display_errors', "On");

// 関数のサンプルプログラム
/* 1.引数があり、戻り値がある例 
 * triangle()
 * 引数で与えられた底辺、高さから三角形の面積を計算し、戻り値で返す
 *   return文が必要
 */

function triangle($a, $b) {
  return ($a * $b / 2);
}

//require_once('10-2.php');
// 関数を利用する

// 関数の戻り値を一度変数に代入
$area = triangle(20, 30);
print "1 指定された三角形の面積は $area です<br>";

// 関数の戻り値を直接出力
print "2 指定された三角形の面積は". triangle(20, 30). "です<br>";

// 関数の引数が変数
$bottom = 20;   // 底辺（10）を変数に代入
$height = 30;   // 高さ（20）を変数に代入
print "3 指定された三角形の面積は" .triangle($bottom, $height)."です<br>";


/* 2.戻り値のない関数の例
 * 　love()
 * 引数で与えられた好きなものから文章を作って、指定された回数文章を出力する
 *  return文がないことに注意
 */

function love($love, $count) {
  for ($i = 1; $i <= $count; $i++) {
    print "私は $love が大好きです！<br>";
  }
}
//love()関数を使ってください
love('いちご',5);

/* 3．デフォルト引数の有る関数の例 
 * message()
 * 引数があってもなくても良い、引数がない場合は関数側で指定した値を取る
 */

function message($flower = 'さくら') {
  print "私の好きな花は $flower です <br>";
}
message();
message('チューリップ');


