<?php
ini_set('display_errors', "On");

//セッション開始
session_start();

//セッション名取得　※デフォルトはPHPSESSIONID
$session_name = session_name();
//print($session_name);

//セッション変数をすべて削除
$SESSION =array();

//ユーザーのcookieに保存されているセッションIDを削除
if(isset($_COOKIE[$session_name])===TRUE){
    setcookie($session_name,'',time()-42000);
}

//セッションIDを無効化
session_destroy();

//処理が完了したらログインページへリダイレクト
header('Location: challenge_session.php');
exit;

?>

