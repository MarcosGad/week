<?php
function lang($phrase){
	static $lang=array(
	//Navbar link
	'Home-Admin'=>'Home',
	
	);
	return $lang[$phrase];
}