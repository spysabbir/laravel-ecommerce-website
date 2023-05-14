$(function() {
	"use strict";
	skinChanger();
    initSparkline();
    CustomJs();

    setTimeout(function() {
        $('.page-loader-wrapper').fadeOut();
    }, 50);
});

// Sparkline
function initSparkline() {
	$(".sparkline").each(function() {
		var $this = $(this);
		$this.sparkline('html', $this.data());
	});
}
//Skin changer
function skinChanger() {
	$('.choose-skin li').on('click', function() {
	    var $body = $('body');
	    var $this = $(this);

	    var existTheme = $('.choose-skin li.active').data('theme');

	    $('.choose-skin li').removeClass('active');
	    $body.removeClass('theme-' + existTheme);
	    $this.addClass('active');
	    var newTheme = $('.choose-skin li.active').data('theme');
	    $body.addClass('theme-' + $this.data('theme'));
	    var darkLogo = "../assets/images/icon-light.svg";
	    var lightLogo = "../assets/images/icon-light.svg";
	    if(newTheme == 'orange' || newTheme == 'purple' || newTheme == 'green'){
		    $('#left-sidebar .navbar-brand .logo').attr('src', darkLogo);
	    }
	    else{
		    $('#left-sidebar .navbar-brand .logo').attr('src', lightLogo);
	    }
	});
}
// All custom js
function CustomJs() {

	// sidebar navigation
	$('#main-menu').metisMenu();

	// sidebar nav scrolling
	// $('#left-sidebar .sidebar-scroll').slimScroll({
	// 	height: 'calc(100vh - 65px)',
	// 	wheelStep: 10,
	// 	touchScrollStep: 50,
	// 	color: '#252a31',
	// 	size: '2px',
	// 	borderRadius: '3px',
	// 	alwaysVisible: false,
	// 	position: 'right',
	// });

	// cwidget scroll
	$('.cwidget-scroll').slimScroll({
		height: '320px',
		wheelStep: 10,
		touchScrollStep: 50,
		color: '#252a31',
		size: '2px',
		borderRadius: '3px',
		alwaysVisible: false,
		position: 'right',
	});

	// toggle fullwidth layout
    $('.btn-toggle-fullwidth').on('click', function() {
        if(!$('body').hasClass('layout-fullwidth')) {
            $('body').addClass('layout-fullwidth');
            $(this).find(".fa").toggleClass('fa-arrow-left fa-arrow-right');

        } else {
            $('body').removeClass('layout-fullwidth');
            $(this).find(".fa").toggleClass('fa-arrow-left fa-arrow-right');
        }
    });
	// off-canvas menu toggle
	$('.btn-toggle-offcanvas').on('click', function() {
		$('body').toggleClass('offcanvas-active');
	});

	$('#main-content').on('click', function() {
		$('body').removeClass('offcanvas-active');
	});

	$('.right_toggle, .overlay').on('click', function() {
		$('#rightbar').toggleClass('open');
		$('.overlay').toggleClass('open');
	});

	// adding effect dropdown menu
	$('.dropdown').on('show.bs.dropdown', function() {
		$(this).find('.dropdown-menu').first().stop(true, true).animate({
			top: '100%'
		}, 200);
	});

	$('.dropdown').on('hide.bs.dropdown', function() {
		$(this).find('.dropdown-menu').first().stop(true, true).animate({
			top: '80%'
		}, 200);
	});

	// navbar search form
	$('.navbar-form.search-form input[type="text"]')
	.on('focus', function() {
		$(this).animate({
			width: '+=50px'
		}, 300);
	})
	.on('focusout', function() {
		$(this).animate({
			width: '-=50px'
		}, 300);
	});

	// Bootstrap tooltip init
	if($('[data-toggle="tooltip"]').length > 0) {
		$('[data-toggle="tooltip"]').tooltip();
	}

	if($('[data-toggle="popover"]').length > 0) {
		$('[data-toggle="popover"]').popover();
	}

	$(window).on('load', function() {
		// for shorter main content
		if($('#main-content').height() < $('#left-sidebar').height()) {
			$('#main-content').css('min-height', $('#left-sidebar').innerHeight() - $('footer').innerHeight());
		}
	});

	$(window).on('load resize', function() {
		if($(window).innerWidth() < 420) {
			$('.navbar-brand logo.svg').attr('src', '../assets/images/icon-light.svg');
		} else {
			$('.navbar-brand icon-light.svg').attr('src', '../assets/images/logo.svg');
		}
	});

    // Wait card Js
	$('[data-toggle="cardloading"]').on('click', function () {
		var effect = $(this).data('loadingEffect');
		var $loading = $(this).parents('.card').waitMe({
			effect: effect,
			text: 'Loading...',
			bg: 'rgba(0,0,0,0.90)',
			color: '#666d77'
		});

		setTimeout(function () {
			//Loading hide
			$loading.waitMe('hide');
		}, 2000);
	});

    // Full screen class
	$('.full-screen').on('click', function() {
		$(this).parents('.card').toggleClass('fullscreen');
    });

    // Select all checkbox
    $('.check-all').on('click',function(){

        if(this.checked){
            $(this).parents('.check-all-parent').find('.checkbox-tick').each(function(){
            this.checked = true;
            });
        }else{
            $(this).parents('.check-all-parent').find('.checkbox-tick').each(function(){
            this.checked = false;
            });
        }
    });

    $('.checkbox-tick').on('click',function(){
        if($(this).parents('.check-all-parent').find('.checkbox-tick:checked').length == $(this).parents('.check-all-parent').find('.checkbox-tick').length){
            $(this).parents('.check-all-parent').find('.check-all').prop('checked',true);
        }else{
            $(this).parents('.check-all-parent').find('.check-all').prop('checked',false);
        }
    });
}
// toggle function
$.fn.clickToggle = function( f1, f2 ) {
	return this.each( function() {
		var clicked = false;
		$(this).bind('click', function() {
			if(clicked) {
				clicked = false;
				return f2.apply(this, arguments);
			}

			clicked = true;
			return f1.apply(this, arguments);
		});
	});
};
