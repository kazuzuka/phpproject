<?php
ini_set('display_errors', "On");

$str='私の電話番号は、03-123-4567、林さんの電話番号は、03-123-4567　郵便番号は、090-8888-9876 どちらも987-1200です';
if(preg_match('/([0-9]{2,4})-([0-9]{2,4})-([0-9]{4})/',$str,$matches)){
    print "電話番号：$matches[0]<br>";
    print "市外局番：$matches[1]<br>";
    print "市内局番：$matches[2]<br>";
    print "加入者番号：$matches[3]<br>";
}

$msg= <<<EOD
        PHP技術者認定試験の資料は、「PHP技術者認定初級試験
        （https://www.phpexam.jp/summary/novice/）」から入手できます。
        無料初級試験対応教材については「無料初級教材」
        （https://www.phpexam.jp/material/phpfree/）をどうぞ。
EOD;
        print preg_replace('|http(s)?://([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?|',
            '<a href="$0">$0</a>',$msg);
        
?>

<!DOCTYPE html>
<html>
    <head lang="ja">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="#" method="get">
            <p><input type="text" pattern=".{3,6}" title="3文字以上6文字以内" size="20"></p>
            <p><input type="text" pattern="([0-9a-zA-Z])*${3}" title="英数字のみ" size="20"></p>
            <p><button type="submit">ボタン</button></p>
    </body>
</html>




