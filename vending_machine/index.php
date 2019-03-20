<?php
ini_set('display_errors', "On");

$db_type = 'mysql';
$db_host = '192.168.100.230';
$db_name = 'phpkiso';

$user = 'member';
$pass = 'member9999';
$charset = 'utf8';

$data = array();
$checked_flag = '';
$img_flag = '';

$dsn = "$db_type:host=$db_host;dbname=$db_name;charset=$charset";

//一覧表示
try {
    $sql="SELECT * FROM drink_master JOIN drink_stock ON drink_master.drink_id = drink_stock.drink_id;";

    //$sql="SELECT * FROM drink_master LEFT OUTER JOIN drink_stock ON drink_master.drink_id = drink_stock.drink_id;";
    $pdo=new PDO($dsn,$user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query('SET NAMES utf8');

    $stmh=$pdo->prepare($sql);// プリペアードステートメントを作成
    
    $stmh->execute();
    while($row=$stmh->fetch(PDO::FETCH_ASSOC)) {
       //var_dump($row); 
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
<html>
    <head lang="ja">
        <meta charset="UTF-8">
        <title>自動販売機</title>
    </head>
    <body>
        <form action="./result.php" method="POST" name="mc">
            <h2>自動販売機</h2>
            <p>
                金額：
                <input type="text" name="cost">
            </p>
            <table class="vending_machine">
                <tr>
                    <?php foreach ($data as $value) { ?>
                        <?php if ($value['status'] == '1') { ?>
                            <td>
                                <img src="<?php print $img_path . $value['img'] ?>" width="200" height="200">
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
        
        

<!--        <h1>自動販売機</h1>
        <form action="result.php" method="POST">
            <div>
                <label><input type="text" name="kingaku" value="">金額</label><br>
                <img src="coce.jpg" >
                <img src="kasa.jpg" >
                <img src="ocya.jpg" ><br>
                <label><input type="radio" name="syurui" value="coke">コーラ</label>
                <label><input type="radio" name="syurui" value="kasa">傘</label>

                <label><input type="radio" name="syurui" value="ocya">お茶</label>

                <label><input type="submit" value="商品購入"></label>
            </div>-->
<!--
        </form>-->

    </body>
</html>
