<?php
session_start();
if(isset($_SESSION['username'])){
	$pagetitle='dashboard';
	include 'init.php';
	echo '<div class="container text-center">';
	echo '<p class="welcome">اهلا و سهلا يا أبونا</p>';
	echo '</div>';
	
	include $tpl.'footer.php';
}else{
	//echo 'you are not authorized to view this page';
	header('location:index.php');
	exit();
}