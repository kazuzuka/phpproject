<?php
ini_set('display_errors', "On");

// データベース関連変数リスト
$db_type = 'mysql';
$db_host = '192.168.100.230';
$db_name = 'phpkiso';
$user = 'member';
$pass = 'member9999';
$charset = 'utf8';
$data = array();
$dsn = "$db_type:host=$db_host;dbname=$db_name;charset=$charset";

$toggle_button = '';

// 「新規商品追加」フォームに値が入力されていれば、レコードをデータベースに追加
if ($_POST) {
    $drink_id = $_POST['drink_id']; // ドリンクID
    $name = $_POST['name'];         // 名前
    $price = $_POST['price'];       // 値段
    $stock = $_POST['stock'];       // 在庫
    $status = $_POST['status'];     // 非公開フラグ
    //$img = $_POST['img'];           // 画像
    ?>
    try {
    $sql = "INSERT INTO drink_master (drink_name,price,img,status) VALUE (:name,:price,:img,:status);";
    $sql .= "INSERT INTO drink_stock (drink_id,stock) VALUE (;drink_id,:stock)";

    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query('SET NAMES utf8');

    $stmh = $pdo->prepare($sql);// プリペアードステートメントを作成
    $stmh->bindParam(':name', $name, PDO::PARAM_STR);
    $stmh->bindParam(':price', $price, PDO::PARAM_STR);
    $stmh->bindParam(':stock', $stock, PDO::PARAM_STR);
    $stmh->bindParam(':status', $status, PDO::PARAM_STR);
    $stmh->bindParam(':img', $img, PDO::PARAM_STR);
    //$stmh->bindParam(':drink_id', $drink_id, PDO::PARAM_STR);
    $stmh->execute();
    $exec_result = $stmh->rowCount();

    //print('   '.$exec_result);
    
    } catch (PDOException $e) {
    die('error:' . $e->getMessage());
    }
    $pdo=null;
    }

    // データベースにアクセス(在庫データを取得)
    try {
    $sql = "SELECT * FROM drink_master LEFT OUTER JOIN drink_stock ON drink_master.drink_id = drink_stock.drink_id;";

    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->query('SET NAMES utf8');

    $stmh = $pdo->prepare($sql);//プリペアードステートメントを実行
    $stmh->execute();
    
    while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
    var_dump($row);
    $data[] = $row;
    }
    print('<pre>');
        var_dump($data);
        print('</pre>');
        
    } catch (PDOException $e) {
    die('error:' . $e->getMessage());
    }
    $pdo = null;
    ?>


    <!DOCTYPE html>
    <html lang="ja">
        <head>
            <meta charset="UTF-8">
            <title>自動販売機管理ツール</title>
        </head>
        <body>
            <h1>自動販売機管理ツール</h1>
            <line>
            <h2>新規商品追加</h2>
            <form action = "#" type="POST">
                <input type="hidden" name="id" value="<?php print($drink_id + 1); ?>">
                名前：<input type="text" name="name"><br>
                値段：<input type="text" name="price"><br>
                個数：<input type="text" name="stock"><br>
                <input type="file" name="img" value="image"><br>
                非公開にする<input type="checkbox" name="status"><br>
                <button type="submit" name="add" value="add">■□■□■商品追加■□■□■</button><br>
            </form>
            <line>
            <h2>商品情報変更</h2>
            <form action = "#" type="POST">
                <h3>商品一覧</h3>

                <table>
                    <tr>
                        <th>商品ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th>ステータス</th>
                    </tr>
                    <?php if (count($data) > 0) { ?>
                        <?php foreach ($data as $value) { ?>
                            <tr>
                                <td>
                                    <?php print($value['drink_id']); ?>
                                </td>
                                <td>
                                    <img src="./img/<?php print($value['img']); ?>" alt="<?php print($value['img']); ?>">
                                </td>
                                <td>
                                    <?php print($value['drink_name']); ?>
                                </td>
                                <td>
                                    <?php print($value['price']); ?>円
                                </td>
                                <td>
                                    <input type="text" name="stock_<?php print($value['drink_id']); ?>" value="<?php print($value['stock']); ?>">個<br>
                                    <button type="submit" name="change_<?php print($value['drink_id']); ?>" value="change_<?php print($value['drink_id']); ?>">変更</button>
                                </td>
                                <td>
                                    <?php
                                    if (!$value['status']) {
                                        $toggle_button = '<button type="submit" name="toggle_' . $value['drink_id'] . '" value="toggle_' . $value['drink_id'] . '">非公開→公開</button>';
                                    } elseif ($value['status'] == 1) {
                                        $toggle_button = '<button type="submit" name="toggle_' . $value['drink_id'] . '" value="toggle_' . $value['drink_id'] . '">公開→非公開</button>';
                                    }
                                    ?>
                            <?php print($toggle_button) . ($value['status']); ?>
                                </td>
                            </tr>
                    <?php } ?>
                    </table>
    <?php } ?>
        </form>
    </body>
</html>
