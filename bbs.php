<?php
$db_type='mysql'; 
$db_host='192.168.100.230';
$db_name='phpkiso';
$user='member';
$pass='member9999';
$charset='utf8';

$data=array();
$name='';
$comment='';
$exec_result=0;

$dsn="$db_type:host=$db_host;dbname=$db_name;charset=$charset";
//post処理
if($_SERVER['REQUEST_METHOD']==='POST') {
    if(isset($_POST['name'])===true && mb_strlen($_POST['name']!==0)) {
        $name= htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8");
    }
    if(isset($_POST['comment'])===true && mb_strlen($_POST['comment']!==0)) {
        $comment= htmlspecialchars($_POST['comment'], ENT_QUOTES, "UTF-8");
    }

    $date=date("Y-m-d H:i:s");
    print($name.$comment.$date);

    try {
    $sql=<<<EOS
            INSERT INTO
            post
            (user_name, user_comment, create_datetime)
            VALUES
            (:name, :comment, :date);
EOS;

   //print($sql);
    $pdo=new PDO($dsn,$user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query('SET NAMES utf8');
    $stmh=$pdo->prepare($sql);
    //var_dump($stmh);

    $stmh->bindParam(':name', $name, PDO::PARAM_STR);
    $stmh->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmh->bindParam(':date', $date, PDO::PARAM_STR);

    $stmh->execute();
    $exec_result=$stmh->rowCount();

    print('   '.$exec_result);


    }catch(PDOException $e) {
    die('error:'.$e->getMessage());
}
$pdo=null;



}//post end



//get処理　一覧表示
try {
    $sql="SELECT id, user_name, user_comment, create_datetime FROM post";

    $pdo=new PDO($dsn,$user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query('SET NAMES utf8');

    $stmh=$pdo->prepare($sql);
    $stmh->execute();
    while($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
       $data[]=$row;
    }
    print('<pre>');
      //var_dump($data);
    print('</pre>');

    }catch(PDOException $e) {
    die('error:'.$e->getMessage());
}
$pdo=null;


?>
<!DOCTYPE html>
<html lang='ja'>
    <head>
        <meta charset="UTF-8">
        <title>掲示板</title>
    </head>
    <body>
        <h1>一言掲示板</h1>
        <form action="#" method="POST">
            氏名:<input type="text" name="name"><br>
            コメント:<input type='text' name='comment' size="50"> <br>
            <input type="submit" value="投稿">
        </form>

        <h2>コメント一覧</h2>
        <ul>
            <?php foreach($data as $value) { ?>
                <li><?php print($value['user_name']."\t".$value['user_comment']."\t".$value['create_datetime']); ?></li>
            <?php } ?>
        </ul>

    </body>
</html>
