<?php
function lang($phrase){
	static $lang=array(
	//Navbar link
	'Home-Admin'=>'Home',
	'Reservation'=>'Reservation',
	'ads'       =>'ads',
	'Members'   =>'Members',
	'Statistics'=>'Statistics',
	'Logs'      =>'Logs',
	);
	return $lang[$phrase];
}