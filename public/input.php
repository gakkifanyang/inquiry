<?php

ob_start();
session_start();

var_dump($_SESSION);

/*
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
 var_dump($input_data);
//validate
//address,body�͕K�{����

$error_flg = [];
if ('' === $input_data['address']){
	//�G���[
	$error_flg[] = 'address_empty'= 1;
}
if ('' === $input_data['body']){
	//�G���[
	$error_flg[] ='body_empty'= 1;
}
//
if ([] !== $error_flg) {
	$_SESSION['input'] = $input_data;
	$_SESSION['error'] = $error_flg;
	
	//�G���[���������Ă�
	header('location: ./form.php');
	exit;
	
}
		
  
  
  
  
var_dump($_POST);





exit;
header('location: fin.html');
