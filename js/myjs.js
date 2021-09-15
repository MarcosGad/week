$(function () {
    'use strict';
	
	
//hide placeholder on form focus
	
	$('[placeholder]').focus(function(){
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).blur(function(){
		$(this).attr('placeholder',$(this).attr('data-text'));
	});
    
	
 // start slider 
	
$('.owl-carousel ').owlCarousel({
    loop:true,
    margin:10,
	autoplay:true,
    //nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});
    
    
 //add asterix on required field
	$('input').each(function(){
		if($(this).attr('required')==='required'){
	        $(this).after('<span class="asterisk">*</span>');
		}
	});
    
    
	
	// like 
	
	
    
    
  }); 
	
	
	
        