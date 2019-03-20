<?php
ini_set('display_errors', "On");

//セッション開始
session_start();
$access_flag = FALSE;
$count = 1;
$lasttime = '';

if (isset($_SESSION['visited'])){
    $count = $_SESSION['visited']+1;
}
if (isset($_SESSION['timestamp'])){
    $lasttime = $_SESSION['timestamp'];
    $access_flag = TRUE;
}

$now = date("Y年m月d日　H時i分s秒");
$_SESSION['visited'] = $count;
$_SESSION['timestamp'] = $now;

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
        <form action="./challenge_session_delete.php" method="post">
            <input type="submit" value="履歴削除">
        </form>

    </body>
</html>
