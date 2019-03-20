<?php
ini_set('display_errors', "On");

$access_flag = FALSE;
$count = 1;
$lasttime ='';

if (isset($_COOKIE['visited'])){
    $count = $_COOKIE['visited']+1;
}
if (isset($_COOKIE['timestamp'])){
    $lasttime = $_COOKIE['timestamp'];
    $access_flag = TRUE;
}
$now = date("Y年m月d日　H時i分s秒");
setcookie('visited',$count,time()+60*60*24*365);
setcookie('timestamp',$now,time()+60*60*24*365);
?>


<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>課題</title>
    </head>
    <body>
        <?php if($count > 1){ ?>
        <p>合計　<?php print $count; ?>回目のアクセスです</p>
        <?php } else{ ?>
        <p>初めてのアクセスです</p>
        <?php } ?>
        <p><?php print $now; ?>(現在日時)</p>
        <?php if($access_flag){ ?>
        <p><?php print $lasttime; ?>（前回のアクセス日時）</p>
        <?php } ?>
        <form action="./challenge_cookie_delete.php" method="post">
            <input type="submit" value="履歴削除">
        </form>

    </body>
</html>
