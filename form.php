<?php
ini_set('display_errors', "On");
// フォームデータチェックのサンプルプログラム
$datas = [];
$errors = [];
$how = [];
$list = ['friends','magazine'];
$pattern1 = '/^[0-9]{3}-[0-9]{4}$/'; // 郵便番号パターン



// データが正しく入力されているかチェックする（validation）
// チェックの例
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
// POSTデータのサニタイジング(sanitizing)
  $datas = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

  var_dump($datas);

// チェックボックス
  if (!empty($datas)) {
    $how[] = in_array($list[0], $datas['how']);
    $how[] = in_array($list[1], $datas['how']);
  }
  var_dump($how);

  // 名前のチェック
  if (mb_strlen($datas["name"]) === 0) {
    $errors['name'] = 'お名前を入力してください';
  } elseif (mb_strlen($datas["name"]) > 20) {
    $errors['name'] = 'お名前は20文字以内で入力してください';
  }
  // メールアドレスのチェック
if (!filter_var($datas["mail"], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Eメールアドレスの形式が不正です';
}
  // 郵便番号のチェック
  if (!preg_match($pattern1, $datas["post_code"])) {
    $errors['name'] = '郵便番号の形式で入力して下さい';
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
    <form action="form.php" method="post">
       <?php if (count($errors) > 0) { ?>
        <ul>
            <?php foreach ($errors as $error) { ?>
            <li>
                <?php print htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
           <div>
        <label for="name">お名前：</label>
        <input type="text" name="name" id="name" value="<?php print $datas["name"];?>">
      </div>
      <div>
        <label for="mail">メールアドレス：</label>
        <input type="email" name="mail" id="mail" value="<?php print $datas["mail"];?>">
      </div>
      <div>
        <label for="password">パスワード：</label>
        <input type="text" name="password" id="password" value="<?php print $datas["password"];?>"
         maxlength="12">
      </div>

      <div>
        <label for="post_code">郵便番号：</label>
        <input type="text" name="post_code" id="post_code" value="<?php print $datas["post_code"];?>"
         placeholder="123-4567">
      </div>
      <div>
        都道府県：
        <select name="pref">
          <option value="">選択してください</option>
          <option value="北海道"<?php if ($datas["pref"] === '北海道'): print 'selected';endif;?>>北海道</option>
          <option value="青森県"<?php if ($datas["pref"] === '青森県'): print 'selected';endif;?>>青森県</option>
          <option value="岩手県"<?php if ($datas["pref"] === '岩手県'): print 'selected';endif;?>>岩手県</option>
          <option value="宮城県"<?php if ($datas["pref"] === '宮城県'): print 'selected';endif;?>>宮城県</option>
          <option value="山形県"<?php if ($datas["pref"] === '山形県'): print 'selected';endif;?>>山形県</option>
          <option value="">サンプルのため以下省略</option>
        </select>
      </div>
      <div>
        性別：
        <label><input type="radio" name="gender" value="man"<?php if ($datas["gender"] === 'man'): print 'checked';endif;?>>男性</label>
        <label><input type="radio" name="gender" value="woman"<?php if ($datas["gender"] === 'woman'): print 'checked';endif;?>>女性</label>
      </div>
      <div>
        メール配信：
        <label><input type="radio" name="magazin" value="1"
        <?php if ($datas["magazin"] === '1'|| $datas["magazin"] == NULL ): print 'checked';endif;?>>希望する</label>
         <label><input type="radio" name="magazin" value="0"
        <?php if ($datas["magazin"] === '0'): print 'checked';endif;?>>希望しない</label>
      </div>
      <div>
          <label>当サイトをお知りになったきっかけ：</label><br>
          <label><input type="checkbox" name="how[]" value="friends"
            <?php if(!empty($how) && ($how[0])): print 'checked';endif;?>>知り合いの紹介で</label>
          <label><input type="checkbox" name="how[]" value="magazine"
            <?php if(!empty($how) && ($how[1])): print 'checked';endif;?>>雑誌・Webサイトで見て</label>
      </div>
      <div>
          <label>お問い合わせの具体的な内容：<br>
            <textarea name="message" ><?php print $datas["message"];?></textarea>
          </label>
      </div>
      <div>
        <input type="submit" value="送信">
        <input type="reset"  value="クリア">
      </div>
    </form>
    </div>
</html>

