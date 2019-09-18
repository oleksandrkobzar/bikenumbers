$(function() {
	$(window).scroll(function() {
	    if ($(window).scrollTop() >= "250") {
	        $("nav").addClass("fixed-top");
	    } else {
	        $("nav").removeClass("fixed-top");
	    }
	});
});