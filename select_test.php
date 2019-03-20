<?php
ini_set('display_errors', "On");

$db_type = 'mysql';
$db_host = '192.168.100.230';
$db_name = 'phpkiso';
$user = 'member';
$pass = 'member9999';
$charset = 'utf8';
$data=array();


$dsn="$db_type:host=$db_host;dbname=$db_name;charset=$charset";

if(isset($_POST['btn']) === true && $_POST['btn'] !== '') {
    $btn = htmlspecialchars($_POST['btn'], ENT_QUOTES, 'UTF-8');
//print($btn);
    if($btn === 'select') {
        print('select処理に入りました');
        $pname=$_POST['product_name'];
        try {
        $sql=<<<EOS
            SELECT
            goods_id, goods_name, price
            FROM
            goods_table;
EOS;

   //print($sql);
    $pdo=new PDO($dsn,$user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query('SET NAMES utf8');

    $stmh=$pdo->prepare($sql);
    $stmh->execute();
    while($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row);
       $data[]=$row;
    }
    print('<pre>');
    var_dump($data);
    print('</pre>');
    }catch(PDOException $e) {
    die('error:'.$e->getMessage());
}
    $pdo=null;
// select処理終了
    }else{//btn select分岐
      if (is)
      print('search処理に入りました');
        try {
        $sql=<<<EOS
            SELECT
            goods_id, goods_name, price
            FROM
            goods_table WHERE goods_name = :key;
EOS;

   //print($sql);
    $pdo=new PDO($dsn,$user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query('SET NAMES utf8');
    
    $stmh=$pdo->prepare($sql);
    $stmh->bindParam(':key',$pname,PDO::PARAM_STR);
    $stmh->execute();
    while($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
        //var_dump($row);
       $data[]=$row;
    }
    
    print('<pre>');
    var_dump($data);
    print('</pre>');

    }catch(PDOException $e) {
    die('error:'.$e->getMessage());
}
$pdo=null;
}
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <h1>SQL TEST</h1>
    <form action="#" method="POST">
      <button type="submit" name="btn" value="select">
        一覧表示
      </button>
      <p>
      <input type="text" name="product_name">
      <button type="submit" name="btn" value="search">
        検索
      </button>
      </p>
    </form>
    <?php if(count($data)>0) { ?>
    <table>
        <tr>
          <th>商品ID</th>
          <th>商品名</th>
          <th>価格</th>
        </tr>
        <?php foreach($data as $value) { ?>
          <tr>
            <td><?php print($value['goods_id']); ?></td>
            <td><?php print($value['goods_name']); ?></td>
            <td><?php print($value['price']); ?></td>
        </tr>
        <?php } ?>
    </table>
    <?php } ?>
  </body>
</html>

