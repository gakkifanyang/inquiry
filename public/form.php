<?php
//form.php
ob_start();
session_start();
//var_dump($_SESSION);
//入力dataを取得

$input_data = [];
if(isset($_SESSION['input'])){
	$input_data = $_SESSION['input'];
	unset($_SESSION['input']);
}
//error dataを取得
$error = [];
if(isset($_SESSION['error'])){
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
}	

//XSS対策
function h($s) {
	return htmlspecialchars($s,ENT_QUOTES);
}
?>
<h1>お問い合わせフォーム</h1>
<?php
if (true === isset($error['address_empty'])){
	echo 'address必須入力<br>';
}	

if (true === isset($error['body_empty'])){
	echo '問い合わせ内容必須入力<br>';
}
?>

<form action ="./input.php" method="post">

お名前:<br><input name="name"
	value="<?php echo h(@$input_data['name']); ?>"><br>
メールアドレス:<br><input name="address"
	value="<?php echo h(@$input_data['address']); ?>"><br>
お問い合わせ内容:<br>
<textarea name="body" ><?php echo h(@$input_data['body']); ?></textarea><br>
<input type="file"><br><br>

<button type="submit">送信</button>

</form>
 
