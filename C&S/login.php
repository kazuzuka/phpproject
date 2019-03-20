<?php
ini_set('display_errors', "On");

session_start();

if (isset($_SESSION['id'])) {
    //セッションにユーザーIDがある＝ログインしている
    //トップページに遷移する
    header('Location: index.php');
}
 else if(isset ($_POST['name']) && isset ($_POST['password'])){
//ログインしていないがユーザー名とパスワードが送信されたとき
//データベースに接続
$dsn = 'mysql:host=192.168.100.230;dbname=c_s;charset=utf8';
$user = 'member';
$password = 'member9999';

try{
$db = new PDO($dsn, $user, $password);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//プリペアードステートメントを作成
$stmt = $db->prepare("
        SELECT * FROM users WHERE name=:name AND password=:pass
        ");

//パラメータを割り当て
$stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
$stmt->bindParam(':pass', sha1($_POST['password']), PDO::PARAM_STR);

//クエリの実行
$stmt->execute();

if($row = $stmt->fetch()){
//ユーザが存在していたので、セッションにユーザーIDをセット
$_SESSION['id'] = $row['id'];
header('Location: index.php');
exit();
}else{
//1レコードも取得できなかったとき
//ユーザ名・パスワードが間違っている可能性あり
//もう一度ログインフォームを表示
header('Location: login.php');
exit();
}
} catch(PDOException $e){
die('エラー：'.$e->getMessage());
}
}else {
    //ログインしていない場合はログインフォームを表示する
    ?>

    <!DOCTYPE html>
    <html>
        <head lang="ja">
            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
            <title>テニスサークル交流サイト</title>
        </head>
        <body>
            <h1>テニスサークル交流サイト</h1>
            <h2>ログイン</h2>
            <form action="index.php" method="post">
                <p>ユーザ名：<input type="text" name="name"></p>
                <p>パスワード：<input type="password" name="password"></p>
                <p><input type="submit" value="ログイン"></p>
            </form>
        </body>
    </html>
<?php } ?>
