<?php
function lang($phrase){
	static $lang=array(
	'home'=>'الصفحة الرئيسية',
	'Reservation'=>'بيانات الحجز',
	'ads'       =>'التنبيه',
	'Members'   =>'الأعضاء',
	'artical'   =>'ادارة المقال',
	);
	return $lang[$phrase];
}