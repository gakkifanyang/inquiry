<?php
//github.com gallu 2018_
ob_start();
session_start();
require_once(__DIR__ . '/../config.php');
//var_dump($_SESSION);

/*
//入力値の取得方法
$name =(string@$_POST ['name'];
$name =@$_POST['name'] ??;
$namae =(string) filter_input(INPUT_POST, 'name');
if (true === isset ($_POST['name'])) {
  $name=$_POST['name'];
  }else{
  $name='';
  }*/
  
  
  /*
  $name =@$_POST['name']??'';
   $adress =@$_POST['adress']??'';
    $body=@$_POST['body']??'';
    */
  
  
  $params= ['name','address','body'];
  $input_data = [];//入力値
  foreach($params as $p){
      $input_data[$p] = @$_POST [$p] ??'';
  }
  //var_dump($input_data);
 
//validate
//address,bodyは必須入力
$error_flg = [];
if ('' === $input_data['address']){
	//エラー
	$error_flg['address_empty']= 1;
}
if ('' === $input_data['body']){
	//エラー
	$error_flg['body_empty']= 1;
}
//
if ([] !== $error_flg) {
//form phpにデータを渡す
	$_SESSION['input'] = $input_data;
	$_SESSION['error'] = $error_flg;
	
	//エラーが発生してる
	header('location: ./form.php');
	exit;
}


//DBの接続
$dsn = sprintf("mysql:dbname=%s;host=%s;charset=%s"
			,$config['db']['dbname']
			,$config['db']['host']
			,$config['db']['charset']);
$user = $config['db']['user'];
$pass = $config['db']['pass'];
//Myqsl固有の設定
$opt = [
	//静的ブレースホルダを指定
	PDO::ATTR_EMULATE_PREPARES => false,
	//複文禁止
	PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
];
try{
	$dbh = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
	echo 'DB Connect error: ', $e->getMessage();
	exit;
}
//var_dump($dbh);

//DBへのINSERT
//準備された文の作成
$sql = 'INSERT INTO inquiry(name,address, body, created_at)
			VALUES(:name, :address, :body, now());';
$pre = $dbh ->prepare($sql);
//var_dump($pre); exit;

 
//ブレースホルダへの値のバインド
$pre->bindValue(':name'   ,$input_data['name'],PDO::PARAM_STR);//正しい
$pre->bindValue(':address',$input_data['address']);//文字列なら省略可
$pre->bindValue(':body'   ,$input_data['body']);

//SQLの実行
$r = $pre->execute();
var_dump($dbh->errorInfo() );
var_dump($r);exit;



 


exit;
header('location: fin.html');
