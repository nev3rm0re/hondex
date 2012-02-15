$(function(){
	Cufon.replace('#header .menu a, h2, h3, .block-top-10 .position .number, .block-news .date, #content .head .timer');

	Cufon.replace('.qualify-here .button a', {
		textShadow: '1px 1px #570708'
	});
	
	Cufon.replace('.q-number, .q-content label');
	
	Cufon.replace('.q-content .button a', {
		textShadow: '1px 1px #434344'
	});
	
	$('input.form-text', '#header .login, #content').each(function(i){
		if($(this).val() != '')
			$(this).siblings('label').hide();
		
		$(this)
			.focus(function(){
				$(this).siblings('label').hide();
			})
			.blur(function(){
				if($(this).val() == '')
					$(this).siblings('label').show();
			});
			
		$(this).siblings('label').click(function(e){
			e.preventDefault();
			$(this).siblings('input.form-text, textarea').focus();
		});
	});
	
	$('.form-register form').submit(function(){
		$('.form-success').fadeIn();
		return false;
	});
	
	$('.form-success .close').click(function(e){
		e.preventDefault();
		$(this).parents('.form-success').fadeOut();
	});
	
	//09.04.2012 12:00
	var final_date = new Date(2012, 3, 9, 12); 
	$('#header .countdown .time').countdown({
		until: final_date,
		compact: true,
		layout: '{dn}:{hnn}:{mnn}:{snn}'
	});

	$('a.fancybox').fancybox({
		overlayShow: false
	});
	
	$('.q-content .form-radio').uniform();
});