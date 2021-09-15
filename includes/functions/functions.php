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
** check items function v1.0
**function to check item in database [function accept parameters]
**$select = the item to select [example : user , item , category]
**$from = the table to select from [example : users , items , categories ]
**$value = the value of select [example : osama , box , electronics]
*/

function checkItem ($select , $from , $value) {
	
	global $con; 
	
	$statement = $con->prepare("select $select from $from where $select = ? "); 
	
	$statement->execute(array($value)); 
	
	$count = $statement->rowCount(); 
	
	return $count; 
}