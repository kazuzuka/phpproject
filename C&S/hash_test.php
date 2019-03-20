<?php

ini_set('display_errors',"On");

$str1="これはハッシュのもとになるストリング";
$str2="ハッシュポテト";
$sault="塩コショウ";
$hashed_str1=hash('sha256',$str1.$sault);
$hashed_str2=hash('sha256',$str2.$sault);

print($hashed_str1."文字長".mb_strlen($hashed_str1));
print('<br>');
print($hashed_str2."文字長".mb_strlen($hashed_str2));
print('<br>');

if(hash('sha256',$str1)===$hashed_str1){
    print('ハッシュ化された文字と一致');
} else {
print('一致しません');    
}



?>

