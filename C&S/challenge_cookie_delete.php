<?php
ini_set('display_errors', "On");
$now = date("Y年m月d日 H時i分s秒");
setcookie('visited','',$now-3600);
setcookie('timestamp','',$now-3600);

//処理が完了したらログインページへリダイレクト
header('Location:challenge_cookie.php');
exit;
?>
