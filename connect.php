<?php
$dsn='mysql:host=localhost;dbname=week';
$user='root';
$pass='';
$option=array(
PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8'
);
try{
	$con=new PDO($dsn,$user,$pass,$option);
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	//echo'you are connected welcome to database';
}
catch(PDOException $e){
	echo 'failed to connect'.$e->getMessage();
}
