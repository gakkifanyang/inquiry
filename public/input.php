<?php
//github.com gallu 2018_
ob_start();
session_start();
require_once(__DIR__ . '/../config.php');
//var_dump($_SESSION);

/*
//���͒l�̎擾���@
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
  $input_data = [];//���͒l
  foreach($params as $p){
      $input_data[$p] = @$_POST [$p] ??'';
  }
  //var_dump($input_data);
 
//validate
//address,body�͕K�{����
$error_flg = [];
if ('' === $input_data['address']){
	//�G���[
	$error_flg['address_empty']= 1;
}
if ('' === $input_data['body']){
	//�G���[
	$error_flg['body_empty']= 1;
}
//
if ([] !== $error_flg) {
//form php�Ƀf�[�^��n��
	$_SESSION['input'] = $input_data;
	$_SESSION['error'] = $error_flg;
	
	//�G���[���������Ă�
	header('location: ./form.php');
	exit;
}


//DB�̐ڑ�
$dsn = sprintf("mysql:dbname=%s;host=%s;charset=%s"
			,$config['db']['dbname']
			,$config['db']['host']
			,$config['db']['charset']);
$user = $config['db']['user'];
$pass = $config['db']['pass'];
//Myqsl�ŗL�̐ݒ�
$opt = [
	//�ÓI�u���[�X�z���_���w��
	PDO::ATTR_EMULATE_PREPARES => false,
	//�����֎~
	PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
];
try{
	$dbh = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
	echo 'DB Connect error: ', $e->getMessage();
	exit;
}
//var_dump($dbh);

//DB�ւ�INSERT
//�������ꂽ���̍쐬
$sql = 'INSERT INTO inquiry(name,address, body, created_at)
			VALUES(:name, :address, :body, now());';
$pre = $dbh ->prepare($sql);
//var_dump($pre); exit;

 
//�u���[�X�z���_�ւ̒l�̃o�C���h
$pre->bindValue(':name'   ,$input_data['name'],PDO::PARAM_STR);//������
$pre->bindValue(':address',$input_data['address']);//������Ȃ�ȗ���
$pre->bindValue(':body'   ,$input_data['body']);

//SQL�̎��s
$r = $pre->execute();
var_dump($dbh->errorInfo() );
var_dump($r);exit;



 


exit;
header('location: fin.html');
