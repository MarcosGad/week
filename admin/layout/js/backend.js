// JavaScript Document
$(function(){
	'use strict';
	//hide placeholder on form focus
	$('[placeholder]').focus(function(){
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));
	});// this = [placeholder]
	
	
	
	
	
	//add asterix on required field
	$('input').each(function(){
		if($(this).attr('required')==='required'){
			$(this).after('<span class="asterisk">*</span>');
		}
	});
	//convert password field to text field on hover
	var passfield=$('.password');
	$('.show-pass').hover(function(){
		passfield.attr('type','text');
	},function(){
		passfield.attr('type','password');
	});
	//confirmation message on button
	$('.confirm').click(function(){
		return confirm('are you sure?');
	});
}); 