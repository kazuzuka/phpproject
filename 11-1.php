
<?php
ini_set('display_errors', "On");

// 関数のサンプルプログラム

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

print $_SERVER['REQUEST_METHOD']."<br>";

//
if ($_SERVER['REQUEST_METHOD']==='POST') {
// HTMLから値を受け取る
  $name = $_POST['name'];

// 値が空である
  if (empty($name)) {
    echo "名前が何も入力されていません<br>";
    //return ;
  }else{

// 空でなければ出力する
  echo "入力された名前は", h($name), "です。<br>";
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>TODO supply a title</title>
    <meta charset="UTF-8">
  </head>
  <body>
    <!--<form action=11-2.php method=post>-->
    <form action="<?php print $_SERVER['PHP_SELF'];?>" method="post">
      名前:<input name="name"><br>
      <br>
      <button type="submit">送信する</button>
    </form>
  </body>
</html>
