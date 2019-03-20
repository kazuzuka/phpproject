<?php
ini_set('display_errors', "On");
// 様々なフォーム部品の値を取得するサンプルプログラム

// commonファイルを読み込み
// reruire()関数は別のファイルをその場所に読み込みます　cf.include()
// reruire_once()関数は、一度読み込んでいる場合は再度読み込みません
require_once('common/const.php');  // 関数の読み込み
require_once('common/common.php');   // 関数の読み込み


$errors = array();
$list = array('friends','magazine');
$pattern1 = '/^[0-9]{3}-[0-9]{4}$/'; // 郵便番号パターン
// 変数の定義
$name = '';
$mail = '';
$password = '';
$post_code = '';
$pref = '';
$gender = '';
$magazin = '';
$how = array();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  //var_dump($_POST);
  //htmlspecialchar 異常な値を取り除く（sanitizing）
  if(isset($_POST['name'])===true){
    $name = entity_str($_POST['name']);
  }
  if(isset($_POST['mail'])===true){
    $mail = entity_str($_POST['mail']);
  }
  if(isset($_POST['password'])===true){
    $password = entity_str($_POST['password']);
  }
  if(isset($_POST['post_code'])===true){
    $post_code = entity_str($_POST['post_code']);
  }
  if(isset($_POST['pref'])===true){
    $pref = entity_str($_POST['pref']);
  }
  if(isset($_POST['gender'])===true){
    $gender = entity_str($_POST['gender']);
  }
  if(isset($_POST['message'])===true){
    $message = entity_str($_POST['message']);
  }
  // checkboxは配列で送信される
  if(isset($_POST['how'])===true){
    $how = entity_array($_POST['how']);
  }

  // フォームデータのチェック (validate)
  // 名前のチェック
  if (mb_strlen($name) === 0) {
    $errors['name'] = 'お名前を入力してください';
  } elseif (mb_strlen($name) > 20) {
    $errors['name'] = 'お名前は20文字以内で入力してください';
  }
  // メールアドレスのチェック　
  // メールアドレスのチェックは下記の関数が丁寧ですが、それでも十分とは言えない
  // 
  //  if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  //    $errors['email'] = 'Eメールアドレスの形式が不正です';
  //  }
  // 郵便番号のチェック //preg_match：第1引数に指定した正規表現のパターンが第2引数に指定した文字列に合っているかをチェックする
  if (!preg_match($pattern1, $post_code)) {
    $errors['post_code'] = '郵便番号の形式で入力して下さい';
  }
// チェック終り
// エラーがない場合、データベースに登録する

}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>form</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <div id="wrapper">
    <h2>お問い合わせ</h2>
    <!-- $_SERVER['PHP_SELF']は現在のスクリプトの名前 -->
    <form action="<?php print $_SERVER['PHP_SELF'];?>" method="post">
      <!-- エラー表示 -->
       <?php if (count($errors) > 0) : ?>
        <ul>
            <?php foreach ($errors as $error):?>
            <li>
                <?php print htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif; ?>

      <div>
        <label for="name">お名前：</label>
        <input type="text" name="name" id="name" value="<?php print $name;?>">
      </div>
      <div>
        <label for="mail">メールアドレス：</label>
        <input type="email" name="mail" id="mail" value="<?php print $mail;?>">
      </div>
      <div>
        <label for="password">パスワード：</label>
        <input type="text" name="password" id="password" value="<?php print $password;?>"
         maxlength="12">
      </div>

      <div>
        <label for="post_code">郵便番号：</label>
        <input type="text" name="post_code" id="post_code" value="<?php print $post_code;?>"
         placeholder="123-4567">
      </div>
      <div>
        都道府県：
        <select name="pref">
          <option value="">選択してください</option>
          <option value="北海道"<?php if ($pref === '北海道'): print 'selected';endif;?>>北海道</option>
          <option value="青森県"<?php if ($pref === '青森県'): print 'selected';endif;?>>青森県</option>
          <option value="岩手県"<?php if ($pref === '岩手県'): print 'selected';endif;?>>岩手県</option>
          <option value="宮城県"<?php if ($pref === '宮城県'): print 'selected';endif;?>>宮城県</option>
          <option value="山形県"<?php if ($pref === '山形県'): print 'selected';endif;?>>山形県</option>
          <option value="">サンプルのため以下省略</option>
        </select>
      </div>
      <div>
        性別：
        <label><input type="radio" name="gender" value="man"<?php if ($gender === 'man'): print 'checked';endif;?>>男性</label>
        <label><input type="radio" name="gender" value="woman"<?php if ($gender === 'woman'): print 'checked';endif;?>>女性</label>
      </div>
      <div>
        メール配信：
        <label><input type="radio" name="magazin" value="1"
        <?php if ($magazin === '1'|| $magazin == NULL ): print 'checked';endif;?>>希望する</label>
         <label><input type="radio" name="magazin" value="0"
        <?php if ($magazin === '0'): print 'checked';endif;?>>希望しない</label>
      </div>
      <div>
          <label>当サイトをお知りになったきっかけ：</label><br>
          <label><input type="checkbox" name="how[]" value="friends"
            <?php if(!empty($how) && (in_array($list[0], $how))): print 'checked';endif;?>>知り合いの紹介で</label>
          <label><input type="checkbox" name="how[]" value="magazine"
            <?php if(!empty($how) && (in_array($list[1], $how))): print 'checked';endif;?>>雑誌・Webサイトで見て</label>
      </div>
      <div>
          <label>お問い合わせの具体的な内容：<br>
            <textarea name="message" ><?php print $message;?></textarea>
          </label>
      </div>
      <div>
        <input type="submit" name="submit" value="送信">
       </div>
    </form>
    </div>
</html>

