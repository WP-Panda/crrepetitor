$(document).ready(function(){
	var h = $(window).height();

	$("#ex1 .post").addClass('animated zoomIn');
	
	$(window).scroll(function(){
		if ( ($(this).scrollTop()+h) >= $(".ex2").offset().top) {
			$(".ex2 .post").css({visibility:"visible"});
			$(".ex2 .post").eq(0).addClass('animated bounceInLeft');
			$(".ex2 .post").eq(1).addClass('animated bounceInRight');
		} 
		if ( ($(this).scrollTop()+h) >= $("#ex3").offset().top) {
			$("#ex3 .post").css({visibility:"visible"});
			$("#ex3 .post").eq(0).addClass('animated bounceInLeft');
			$("#ex3 .post").eq(1).addClass('animated bounceInRight');
		} 
		if ( ($(this).scrollTop()+h) >= $("#ex4").offset().top) {
			$("#ex4 .post").css({visibility:"visible"});
			$("#ex4 .post").addClass('animated zoomIn');
		} 
		
		if ( $(this).scrollTop() == 0 ) {
			$("#ex2 .post, #ex3 .post, #ex4 .post").each(function(){
				if ( $(this).hasClass('last') ) {
					$(this).removeClass().addClass('post last');
				} else {
					$(this).removeClass().addClass('post');
				}
				$(this).css({visibility:"hidden"});
			});
		}
	});
});