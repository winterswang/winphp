$(function(){
	$(".menu-slide")
		.mouseover(function() {
			$(this).css({
				"backgroundColor":"#2da7ce",
				"color":"#FFFFFF"
			});
			$(this).find(".t3>a").css("color","#FFFFFF");

		})
		.mouseout(function() {
			$(this).css({
				"backgroundColor":"#d1d1d1",
				"color":"#4e4e4e"
			})
			$(".t3 a").css("color","#4e4e4e");
		})
	$(".slide-list").each(function(i,n){
		if(!$(this).hasClass('active_menu')) {
			$(this).hide();
		}
	});
	$(".t2").click(function() {		
		var sub_menu = $(this).parent().siblings('.slide-list');
		var active_sub_menu = $('.active_menu');
		active_sub_menu.slideUp().removeClass('active_menu');
		if (sub_menu.get(0) !== active_sub_menu.get(0)) {
			sub_menu.addClass('active_menu');
			sub_menu.slideDown();
		}
	})
	$('input[type=file]').bootstrapFileInput();
	//$('.file-inputs').bootstrapFileInput();
	$('.spinedit').spinedit({
	    minimum: 1,
	    maximum: 10,
	    step: 1,
	    value: 0,
	    numberOfDecimals: 0
	});

	var i = setInterval(function(){
		$('.h-fill-animation .progress-bar').progressbar({display_text: 'fill'});
	}, 1000);
})