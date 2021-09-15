<?php
function lang($phrase){
	static $lang=array(
	'message'=>'مرحبا',
	
	);
	return $lang[$phrase];
}