
(function($) {

	skel.breakpoints({
		wide: '(max-width: 1680px)',
		normal: '(max-width: 1280px)',
		narrow: '(max-width: 980px)',
		narrower: '(max-width: 840px)',
		mobile: '(max-width: 736px)',
		mobilep: '(max-width: 480px)'
	});

	$(function() {

		var	$window = $(window),
			$body = $('body'),
			$header = $('#header'),
			$banner = $('#banner');

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on narrower.
			skel.on('+narrower -narrower', function() {
				$.prioritize(
					'.important\\28 narrower\\29',
					skel.breakpoint('narrower').active
				);
			});

		// Dropdowns.
			$('#nav > ul').dropotron({
				alignment: 'right'
			});

		// Off-Canvas Navigation.

			// Navigation Button.
				$(
					'<div id="navButton">' +
						'<a href="#navPanel" class="toggle"></a>' +
					'</div>'
				)
					.appendTo($body);

			// Navigation Panel.
				$(
					'<div id="navPanel">' +
						'<nav>' +
							$('#nav').navList() +
						'</nav>' +
					'</div>'
				)
					.appendTo($body)
					.panel({
						delay: 500,
						hideOnClick: true,
						hideOnSwipe: true,
						resetScroll: true,
						resetForms: true,
						side: 'left',
						target: $body,
						visibleClass: 'navPanel-visible'
					});

			// Fix: Remove navPanel transitions on WP<10 (poor/buggy performance).
				if (skel.vars.os == 'wp' && skel.vars.osVersion < 10)
					$('#navButton, #navPanel, #page-wrapper')
						.css('transition', 'none');

		// Header.
		// If the header is using "alt" styling and #banner is present, use scrollwatch
		// to revert it back to normal styling once the user scrolls past the banner.
		// Note: This is disabled on mobile devices.
			if (!skel.vars.mobile
			&&	$header.hasClass('alt')
			&&	$banner.length > 0) {

				$window.on('load', function() {

					$banner.scrollwatch({
						delay:		0,
						range:		0.5,
						anchor:		'top',
						on:			function() { $header.addClass('alt reveal'); },
						off:		function() { $header.removeClass('alt'); }
					});

				});

			}

	});

})(jQuery);

$(function() {

	// if (Modernizr.touch){
	//    conslole.log('touch');
	// } else {
	//    conslole.log('screen');
	// }

	var standardSliderOptions = {
		autoplay: false,
		slidesToShow: 4,
		slidesToScroll: 1,
		prevArrow: '',
		//prevArrow: $('.standard-arrow.standard-prev'),
		nextArrow: $('.standard-arrow.standard-next'),
		responsive: [
			{
				breakpoint: 1290,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 960,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 430,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	};
	

	if($("#price_range").length){
		rangeSliderActivate();
	}


	$('body').on('click', function(e){
		
	});



	//smartweb scripts
	$('.login-form').on('submit', function(e){
		e.preventDefault();
		var form = $(this);
		var formData = form.serialize();
		$.ajax({
			url: form.attr('action'),
			method: 'post',
			data: formData,
			dataType: 'json',
			//dataType: 'html',
			beforeSend: function(){
				form.find('input').removeClass('is-invalid');
				form.find('label').attr('data-error', '');
				form.find('.invalid-feedback').remove();
				$('.preloader-container').eq(0).clone().css('display', 'block').appendTo(form.find('.modal-content'));
			}
		})
		.done(function(data){
			if(data.success){
				var loginUrl = (form.data('login-url')) ? form.data('login-url') : '/';
				location.href = loginUrl;
			}
			else{
				for(var i in data.errors){
					form.find('input[name=' + i + ']').addClass('is-invalid').after('<span class="invalid-feedback">' + data.errors[i] + '</span>');
				}
			}
		})
		.fail(function(data){
			//console.log(data);
		})
		.always(function(){
			form.find($('.preloader-container')).remove();
		});
	});

	$('.forget-password-form').on('submit', function(e){
		e.preventDefault();
		var form = $(this);
		var formData = form.serialize();
		$.ajax({
			url: form.attr('action'),
			method: 'post',
			data: formData,
			dataType: 'json',
			//dataType: 'html',
			beforeSend: function(){
				form.find('.alert').remove();
				form.find('input').removeClass('is-invalid');
				form.find('label').attr('data-error', '');
				form.find('.invalid-feedback').remove();
				$('.preloader-container').eq(0).clone().css('display', 'block').appendTo(form.find('.modal-content'));
			}
		})
		.done(function(data){
			if(data.success){
				form.find('.modal-body').html('<div class="alert alert-success">' + data.message + '</div>');
				form.find('.modal-footer').remove();
			}
			else{
				for(var i in data.errors){
					form.find('input[name=' + i + ']').addClass('is-invalid').after('<span class="invalid-feedback">' + data.errors[i] + '</span>');
				}
			}
		})
		.fail(function(data){
			//console.log(data);
		})
		.always(function(){
			form.find($('.preloader-container')).remove();
		});
	});

	$('.restore-password-form').on('submit', function(e){
		e.preventDefault();
		var form = $(this);
		var formData = form.serialize();
		$.ajax({
			url: form.attr('action'),
			method: 'post',
			data: formData,
			dataType: 'json',
			//dataType: 'html',
			beforeSend: function(){
				form.find('.alert').remove();
				form.find('input').removeClass('is-invalid');
				form.find('label').attr('data-error', '');
				form.find('.invalid-feedback').remove();
				$('.page-preloader-container').show();
			}
		})
		.done(function(data){
			if(data.success){
				form.html('<div class="alert alert-success">' + data.message + '</div>');
			}
			else{
				for(var i in data.errors){
					form.find('input[name=' + i + ']').addClass('is-invalid').after('<span class="invalid-feedback">' + data.errors[i] + '</span>');
				}
				if(data.errors.unknown){
					form.prepend('<div class="alert alert-danger">' + data.errors.unknown + '</div>');
				}
			}
		})
		.fail(function(data){
			//console.log(data);
		})
		.always(function(){
			$('.page-preloader-container').hide();
		});
	});

	$('.register-form').on('submit', function(e){
		e.preventDefault();
		var form = $(this);
		var formData = form.serialize();
		$.ajax({
			url: form.attr('action'),
			method: 'post',
			data: formData,
			dataType: 'json',
			//dataType: 'html',
			beforeSend: function(){
				form.find('.alert').remove();
				form.find('input').removeClass('is-invalid');
				form.find('label').attr('data-error', '');
				form.find('.invalid-feedback').remove();
				$('.preloader-container').eq(0).clone().css('display', 'block').appendTo(form.find('.modal-content'));
			}
		})
		.done(function(data){
			if(data.success){
				form.find('.modal-body').html('<div class="alert alert-success">' + data.message + '</div>');
				form.find('.modal-footer').remove();
			}
			else{
				for(var i in data.errors){
					form.find('input[name=' + i + ']').addClass('is-invalid').after('<span class="invalid-feedback">' + data.errors[i] + '</span>');
				}
				if(data.errors.unknown){
					form.prepend('<div class="alert alert-danger">' + data.errors.unknown + '</div>');
				}
			}
		})
		.fail(function(data){
			//console.log(data);
		})
		.always(function(){
			form.find($('.preloader-container')).remove();
		});
	});

	$('.subscribe-form').on('submit', function(e){
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		var url = form.attr('action');
		var inputField = form.find('.input-field');
		var icon = inputField.find('.icon').detach();
		inputField.append('<i class="icon fa fa-spin fa-circle-o-notch" style="font-size: 19px"></i>');
		$.ajax({
			url: url,
			dataType: 'json',
			data: data,
			method: 'post',
			beforeSend: function(){
			    $('.page-preloader-container').show();
			}
		})
		.done(function(data){
			if(data.success){
				alert(data.message);
			}
			else{
				alert(data.error);
			}
			
		})
		.fail(function(response, status){
			//console.log(response);
			//console.log(status);
		})
		.always(function(data){
			$('.page-preloader-container').hide();
		});
	});

	$('.product-reviews-form').on('submit', function(e){
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		var url = form.attr('action');
		var btn = form.find('.review-submit-btn');
		btn.after(' <i class="icon fa fa-spin fa-circle-o-notch"></i>');
		$('input, textarea, select').removeClass('invalid');
		$.ajax({
			url: url,
			dataType: 'json',
			data: data,
			method: 'post',
			beforeSend: function(){
			    $('.page-preloader-container').show();
			}
		})
		.done(function(data){
			//console.log(data);
			if(data.success){
				alert(data.message);
			}
			else{
				$('[name]').addClass('valid');
				for(var i in data.errors){
					$('[name=' + i + ']').addClass('invalid');
				}
				alert(data.message);
			}
			
		})
		.fail(function(response, status){
			//console.log(response);
			//console.log(status);
		})
		.always(function(data){
			$('.page-preloader-container').hide();
		});
	});

}); //ready end

$(window).resize(function(){

});//resize end

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function rangeSliderActivate() {
	$("#price_range").ionRangeSlider({
		type: 'double',
		onFinish: function(){
			$('.filter-btn').trigger('click');
		}
	});
}