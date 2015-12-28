	function salvaTroco(){
		troco = document.getElementByName('troco').value;
		alert(troco);
	}

	function altMask(element) {
    $(element).bind('focus.AltMask', function() {
        if ($(this).val() == $(this).attr('alt')) {
            $(this).val("");
        }
    });

    $(element).bind('blur.AltMask', function() {
        if ($(this).val() == "") {
            $(this).val($(this).attr('alt'));
        }
    });
}

$(document).ready(function() {
    altMask("#login-form [name='usuario'], #login-form [name='senha']");
});

 jQuery(function(){
		$("#faded").faded({
		speed: 1000,
		bigtarget: false,
		autoplay: 5000,
		autorestart: false,
		autopagination:false,
		crossfade:true
		});
	});
	$(function() {
		 $(".carousel").jCarouselLite({
			  btnNext: ".next",
			  btnPrev: ".prev",
			  visible: 3,
			  scroll: 1
		 });
	});