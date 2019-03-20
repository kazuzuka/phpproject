<?php
/**
* 特殊文字をHTMLエンティティに変換する(配列)
* @param array  $before_array 変換前配列
* @return $after_array 変換後配列
*/
function entity_array($before_array){
  foreach($before_array as $key => $value){
    $after_array[$key]=htmlspecialchars($value,ENT_QUOTES| ENT_HTML5,'UTF-8');
  }
  return $after_array;
}
/**
* 特殊文字をHTMLエンティティに変換する
* @param str  $str 変換前文字
* @return str 変換後文字
*/
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}
//接続スクリプトの外部化
function getDb(){
  $dsn = 'mysql:dbname=toku3_diary; host=localhost; charset=utf8';
  $usr = 'toku3';
  $passwd = 'diary63';
//データベースへの接続を確立
  $db = new PDO ($dsn, $usr, $passwd);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
}

