<?php
ini_set('display_errors', "On");
// データベースアクセスのサンプルプログラム

// DB接続情報
$host     = '192.168.100.222'; // ホスト名・IPアドレス
$username = 'member';       // MySQLのユーザ名
$password = 'member9999';   // MySQLのパスワード
$dbname   = 'phpkiso';      // MySQLのDB名
$charset  = 'utf8';         // データベースの文字コード
//$host     = 'localhost';
//$username = 'user1';   // MySQLのユーザ名
//$password = 'password';   // MySQLのパスワード
//$dbname   = 'phpkiso';   // MySQLのDB名
//$charset  = 'utf8';   // データベースの文字コード
// MySQL用のDNS文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

$errors = array();   // エラーの場合、エラーメッセージを設定
$data   = array();   // DBから取得した表示データ
$list = $list = [10,20,30,40];
//
// 入力データの取得、チェック
//
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $datas = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

  var_dump($datas);
  // 名前が正しく入力されているかチェックする
  // エラーの場合は、エラーメッセージを設定
  $goods_name = '';
  // 未入力の場合
  if (mb_strlen($datas['goods_name']) === 0){
    $errors['goods_name'] = '名前を入力してください';
  }
  // 20文字より大きい場合
  elseif (mb_strlen($datas['goods_name']) > 20){
    $errors['goods_name'] = '名前は20文字以内で入力してください';
  }
  // 正常の場合
  else {
    $goods_name = $datas['goods_name'];
  }

  // 単価が正しく入力されているかチェックする
  $price = '';
  // 数字でない場合
  if (!is_numeric($datas['price'])||($datas['price']===0) ){
    $errors['price'] = '単価を正しく入力してください';
  }
  // 正常の場合
  else {
    $price = $datas['price'];
  }

// カテゴリーが正しく入力されているかチェックする
  $category = '';
  // 数字でない場合
  if (!is_numeric($datas['category'])){
    $errors['category'] = 'カテゴリーは数字で入力してください';
  }
  // カテゴリーリストにない場合
  elseif (!in_array($datas['category'], $list)){
    $errors['category'] = 'カテゴリーを正しく入力してください';
  }
  // 正常の場合
  else {
    $category = $datas['category'];
  }
}
//
// 入力データをDBに登録し、登録しているデータをDBから取得する
//
try {
  // データベースに接続します
  $dbh = new PDO($dsn, $username, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($errors) === 0) {

    // 現在日時を取得
    $now_date = date('Y-m-d H:i:s');

    // 入力データをDBに登録する
    try {
      // SQL文を作成
      $sql = 'INSERT INTO goods_table(goods_name, price, category) VALUES(?, ?, ?)';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
      // SQL文のプレースホルダに値をバインド
      $stmt->bindValue(1, $goods_name, PDO::PARAM_STR);
      $stmt->bindValue(2, $price, PDO::PARAM_INT);
      $stmt->bindValue(3, $category, PDO::PARAM_INT);
      // SQLを実行
      $stmt->execute();

      // リロード対策でリダイレクト
     header('Location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

    } catch (PDOException $e) {
      throw $e;
    }
  }

  // 登録しているデータをDBから取得する
  try {
    // SQL文を作成
    $sql = 'SELECT * FROM goods_table order by goods_id';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();

    // 1行ずつ結果を配列で取得します
    foreach ($rows as $row) {
      $data[] = $row;
    }
  } catch (Exception $e) {
    throw $e;
  }

} catch (PDOException $e) {
  // 接続失敗した場合
  $errors['db_connect'] = 'DBエラー：'.$e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品一覧</title>
</head>
<body>
  <h1>商品一覧</h1>

  <form action="goods.php" method="post">
    <?php if (count($errors) > 0) { ?>
    <ul>
      <?php foreach ($errors as $error) { ?>
      <li>
        <?php print htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
      </li>
      <?php } ?>
    </ul>
    <?php } ?>
    <label>商品名：<input type="text" name="goods_name"></label>
    <label>単価：<input type="number" name="price" size="10"></label>
    <label>カテゴリー：<input type="number" name="category" size="10"></label>
    <input type="submit" name="submit" value="送信">
  </form>
<?php
?>
  <ul>
    <?php
      // 登録データを表示する
      foreach ($data as $value) {
    ?>
    <li>
      <?php print htmlspecialchars($value[0], ENT_QUOTES, 'UTF-8');?>:
      <?php print htmlspecialchars($value[1], ENT_QUOTES, 'UTF-8');?>
      <?php print htmlspecialchars($value[2], ENT_QUOTES, 'UTF-8');?>
      <?php print htmlspecialchars($value[3], ENT_QUOTES, 'UTF-8');?>
    </li>
    <?php
      }
    ?>
  </ul>
</body>
</html>
