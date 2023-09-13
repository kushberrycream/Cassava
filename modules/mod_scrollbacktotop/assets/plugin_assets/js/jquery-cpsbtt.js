// package 		jquery-cpsbtt.js croll Back to Top Button - FREE VERSION
// version		1.0.2
// created		Sep 2022
// author		CodePlazza
// email		support@codeplazza.com
// website		https://www.codeplazza.com
// support		https://www.codeplazza.com/support.html
// copyright	Copyright (C) 2018 - Today, CodePlazza. All rights reserved.
// license		GNU General Public License version 2 and above!
(function ( $ ) {
			$.fn.cpsbtt = function(options) {
				let settings = $.extend({
					title:"Scroll back to top",
					ofset:"5",
					duration:"1250",
					button_theme: "1",  // 12 different themes, from 1 to 12, if you do not want to use set 0 - set button color below
								
					button_border_thickness:"2px", // if you set button_theme 0, you must set your own button border tickness here.
					button_shape:"circle", // circle
					button_effect: "zoominout",  // zoominout - fadeinout
					button_position: "bottom-right", // bottom-center, bottom-right, top-left, top-center, top-right, center-left, center-right
					icon_color:"#FFF", // if you set button_theme 0, you must set your own icon color here.
					icon_color_hover:"#FFF", // if you set button_theme 0, you must set your own icon color on mouse over here.
					icon_theme:"1", // 5 different button icon avalaible
					icon_size:"medium", // small - medium - large - xlarge
		        }, options );
				
				jQuery('#cp-sbtt').addClass("cp-sbtt");
				$('#cp-sbtt').removeClass('cp-sbtt-active');
		        let themeclass = "cp-sbtt-theme-"+settings.button_theme;
		        let positionclass = "cp-sbtt-pos-"+settings.button_position ;
				let effectclass = "cp-sbtt-effect-"+settings.button_effect ;

				this.addClass(themeclass).addClass(positionclass);
				let $iconsize = 'width="24" height="24"';
				var $svg = '<svg class="cp-sbtt-icon i1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" '+$iconsize+'><path d="M3.6 18.4L12 10l8.4 8.4c.9.9 2.1.9 3 0 .9-.9.9-2.1 0-3l-9.9-9.9c-.9-.9-2.1-.9-3 0L.6 15.4c-.9.9-.9 2.1 0 3 .9.9 2.2.9 3 0z"></path></svg>';				
				jQuery('#cp-sbtt').html('<a class="cp-sbtt-btn" aria-label="'+settings.title+'" title="'+settings.title+'" href="#">'+$svg+'</a>');				
				$(".cp-sbtt-btn").css({"padding": "15px"});	
				$(".cp-sbtt-btn").css({"border-radius": "50%"});
				switch(settings.button_theme){
						case '1':
						$(".cp-sbtt-icon").css({"fill": "#FFF"});
						break;
						case '2':
						$(".cp-sbtt-icon").css({"fill": "#FFF"});
						break;
						case '3':
						$(".cp-sbtt-icon").css({"fill": "#444"});
						break;
						case '4':
						$(".cp-sbtt-icon").css({"fill": "#FFF"});
						break;
						default:
						$(".cp-sbtt-icon").css({"fill": "#FFF"});
						break;					
					}
			$(window).scroll(function() {
					if ($(this).scrollTop() > settings.ofset) {
						$('#cp-sbtt').removeClass('cp-sbtt-active');
						$('#cp-sbtt').addClass(effectclass).addClass('cp-sbtt-active');
					} else {
						if($('#cp-sbtt').hasClass('cp-sbtt-active')){
							$('#cp-sbtt').removeClass('cp-sbtt-active').addClass(effectclass);
						}
					}
				});
				$('#cp-sbtt').click(function(event) {
					event.preventDefault();
					$('html, body').animate({scrollTop: 0}, settings.duration);
					return false;
				})				
				
			};
		}(jQuery));