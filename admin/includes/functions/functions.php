<?php
/*
**title function v1.0
**title function that echo the page title incase the page
**has the variable $pagetitle and echo defult title for other pages
*/
function gettitle(){
	global $pagetitle;
if(isset($pagetitle)){
	echo $pagetitle;
}else{
	echo 'default';
}
}
/*
**home redirect function v1.0
**this function accept parameters
**$errormsg=echo the error message
**$seconds=seconds before redirecting
*/
function redirecthome($errormsg,$seconds=3){
	echo "<div class='alert alert-danger'>$errormsg</div>";
	echo "<div class='alert alert-info'>you will be redirected to home page after $seconds seconds</div>";
	header("refresh:$seconds;url=index.php");
	exit();
}
/*
**check items function v1.0
**function to check item in database [function accept parameters]
**$select=the item to select[example:user,item,category]
**$from=the table to select from[example:users,items,categories]
**$value=the value of select[example:osama,box,electronics]
*/
function checkitem($select,$from,$value){
	global $con;
	$statment=$con->prepare("select $select from $from where $select=?");
	$statment->execute(array($value));
	$count=$statment->rowcount();
	return $count;
}

