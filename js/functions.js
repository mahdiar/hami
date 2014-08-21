jQuery(document).ready(function($) {

	var fixedHeader = $('header#top');

	if (isSticky){
		// Header Smusher (Added in v2.2)
		$(window).bind("scroll", function() {
		
		    var offset = $(this).scrollTop();
		
		    if (offset >= 150) {
		        fixedHeader.addClass('smushed');
		    }
		    else if (offset < 150) {
		        fixedHeader.removeClass('smushed');
		    }
		});
	}
	
	if ($('.project .text').length){
		
		$('.project .text').each(function(){
			
			var h4Height = $(this).find('h4').height();
			if (h4Height > 55){
				$(this).find('p.excerpt').hide();
			}
			
		});
		
	}
	
	$('#campaign-grid img').stop().animate({'opacity':0},0);
    $('#campaign-grid img').each(function(i) {
        if (this.complete) {
            $(this).stop().animate({'opacity':1},1000);
        } else {
            $(this).load(function() {
                $(this).stop().animate({'opacity':1},1000);
            });
        }
    });
	
	if ($('.swiper-container').length){
	
		setTimeout(function(){
			reset_swiper();
		},1000);
		
		$('.swiper-next').click(function(e){
			e.preventDefault();
			mySwiper.swipeNext();
		});
		$('.swiper-prev').click(function(e){
			e.preventDefault();
			mySwiper.swipePrev();
		});
		
		$(window).on('resize', function(){
			reset_swiper();
		});
		
	}
	
	var mySwiper;
	
	if ($('.swiper-container').length){
		
		windowWidth = $(window).width();
		if (windowWidth > 1023){
			swiper_columns = 3;
		} else {
			swiper_columns = 1;
		}
	
		mySwiper = new Swiper('.swiper-container',{
			slidesPerView: swiper_columns,
			slidesPerGroup: swiper_columns
		});
		$('.swiper-next').click(function(e){
			e.preventDefault();
			mySwiper.swipeNext();
		});
		$('.swiper-prev').click(function(e){
			e.preventDefault();
			mySwiper.swipePrev();
		});
	}
	
	if ($('.campaign-tabs').length){
		$('.campaign-tabs').find('.tab').click(function(){
			thisTab = $(this);
			$('.campaign-tabs').find('.tab').removeClass('active');
			thisIndex = thisTab.index();
			thisTab.addClass('active');
			$('.tab-content').find('.tab-block').hide();
			$('.tab-content').find('.tab-block').eq(thisIndex).show();
			return false;
		});
	}

	// Fitvids
	$('.widget .item.video, article.entry, .project-detailed').fitVids();

	$(document).on('focusin', '.field, textarea', function() {
		if(this.title==this.value) {
			this.value = '';
		}
	}).on('focusout', '.field, textarea', function(){
		if(this.value=='') {
			this.value = this.title;
		}
	});
	
	$('.atcf-toggle-neverending').click(function(){
		$('input#length').val('0');
	});
	
	if (typeof parallax != 'undefined' && parallax){
		$('#banner').each(function(){
	        var $bgobj = $(this); // assigning the object
	     
	        $(window).scroll(function() {
	            var yPos = -($(window).scrollTop() / 2.5) * -1;
	            yPos = yPos - 50;
	            var coords = 'center '+ yPos + 'px';
	            $bgobj.css({ backgroundPosition: coords });
	        }); 
	    });
    }
    
    $('.project').fitVids();
    
	$('.modal-popup').magnificPopup({
		type:'inline',
		midClick: true
	});
	
	$('.ask-question-button').click(function(){
		$('#ask-question-block').slideDown(200);
		$(this).hide();
		return false;
	});

	// Main Navigation Dropdowns
	if($('nav > ul > li > ul').length) {
        $('nav > ul > li > ul').each(function() {
            
            $(this).parent().addClass('has-dd');
            $(this).wrap('<div class="dd" />');
            
            if($(this).find('ul').length) {
                $(this).find('ul > li:first').addClass('first');
                $(this).find('ul > li:last').addClass('last');
            }
            $(this).show();
        });
    }
    
    if ($('.mobile-nav-toggle').length) {
		$('.mobile-nav-toggle').bind("click touch", function(){
			$(this).toggleClass('active');
			if($(this).hasClass('active')){ $(this).html('&times;'); } else { $(this).html('+'); }
			$('#mobile-nav > ul').slideToggle('fast');
		});
	}

	$('.dd').animate({opacity:0},0);

    $('nav > ul > li').on('mouseenter', function() {
    	if($(this).find('.dd').length) {
    		if($.browser.msie && $.browser.version < 9) {
                $(this).find('.dd').show().animate({opacity:1},0);
            } else {
                $(this).find('.dd').show().stop().animate({opacity:1},200,'easeOutQuad');
                $(this).find('.dd > ul').stop().animate({'padding-top':10},200,'easeOutQuad');
            }
    	}
    }).on('mouseleave', function() {
    	if($(this).find('.dd').length) {
    		if($.browser.msie && $.browser.version < 9) {
                $(this).find('.dd').animate({opacity:0},0,function(){
                	$(this).hide();
                });
            } else {
            	$(this).find('.dd > ul').stop().animate({'padding-top':5},200,'easeOutQuad');
                $(this).find('.dd').stop().animate({opacity:0},200,'easeInQuad',function(){
                	$(this).hide();
                });
            }
    	}
    });


	// Homepage Featured Projects
	
	if ($('#bb-bookblock').length){
	
		var sliderClicked = false;
	
		$('.col3 nav li:eq(0)').addClass('active');
	
		var bb = $('#bb-bookblock').bookblock({
			perspective	: 1500,
			speed		: 600,
			shadowSides : 0.5,
			interval	: slider_auto_cycle_speed,
			autoplay 	: slider_auto_cycle,
			shadowFlip  : 0.5,
			onEndFlip   : function(page,isLimit) {
			
				if (sliderClicked){
					sliderClicked = false;
				} else {
					
					totalPages = $('.bookblock-nav').find('nav a').length;
					totalPages = totalPages - 1;
				
					var actualPage = page + 1;
					if (actualPage > totalPages){ actualPage = 0; }
					var bbnav = $('.bookblock-nav').find('nav a');
					var $dot = $('.bookblock-nav').find('nav a').eq(actualPage);
					bbnav.parent().removeClass( 'active' );
					$dot.parent().addClass( 'active' );
				}
				
			}
		});
		
		var bbnav = $('.bookblock-nav').find('nav a');
		bbnav.each( function( i ) {
									
			$( this ).bind("click touch", function(event){
				
				var $dot = $( this );
				if( !bb.isActive() ) {
					bbnav.parent().removeClass( 'active' );
					$dot.parent().addClass( 'active' );
					sliderClicked = true;
				}
				bb.jump( i + 1 );
				return false;
			
			} );
			
		} );

	}

	
	
	// Projects Lists
	
	if ($('#projects-masonry').length){
	
		$('#projects-masonry').masonry({
			itemSelector : '.project-block',
			isAnimated: true,
			columnWidth: 300,
			gutterWidth: 20
		});
	
	}
	
	// Profile Projects List
	
	if ($('.atcf-profile-campaigns').length){
	
		$('.atcf-profile-campaigns').masonry({
			itemSelector : '.atcf-profile-campaign-overview',
			isAnimated: true,
			columnWidth: 300,
			gutterWidth: 20
		});
	
	}
	
	$('#content .edd_download_purchase_form').remove();
	
	$( '.edd_price_options_input' ).css( 'display', 'none' );

	$( '.edd_price_options li' ).bind("click touch", function(e){
		e.preventDefault();
		
		if ($(this).hasClass('inactive')){
		
			return false;
		
		} else {

			var pledge = $( this );
			
			var price = pledge.attr('data-price');
			price = price.split('-');
			price = price[0];
			$('input[name=atcf_custom_price]').val(price);
			
			$( '.edd_price_options li' )
				.removeClass( 'active' )
				.find( 'input' ).prop( 'checked', false );
	
			pledge
				.addClass( 'active' )
				.find( 'input' ).prop( 'checked', 'checked' );
	
			pledge.parents( 'form' ).submit();
			
		}
	});
	
	
	$('input[name=atcf_custom_price]').change(function(){
	
		thisField = $(this);
	
		var enteredPrice = parseInt($(this).val());
		$('.edd_price_options').find('li').removeClass('active');
		$(this).find('input').prop('checked',false);
		
		// Find lowest price
		var lowestPrice = 999999999999;
		$('.edd_price_options').find('li').each(function(){
			var price = $(this).attr('data-price');
			price = price.split('-');
			price = parseInt(price[0]);
			if (price < lowestPrice){ lowestPrice = price; }
		});
			
		$('.edd_price_options').find('li').each(function(){
			var price = $(this).attr('data-price');
			price = price.split('-');
			price = parseInt(price[0]);
			
			if (enteredPrice < lowestPrice){
				enteredPrice = lowestPrice;
				thisField.val(enteredPrice);
			}
			
			if (enteredPrice >= price){
				$('.edd_price_options').find('li').removeClass('active');
				$(this).find('input').prop('checked','checked');
				$(this).addClass('active');
			} else {
				return false;
			}
		});
	});

	var arrow = $('span.arrow');
	var arrow_start = -30;
	var arrow_end = -160;
	arrow.css('opacity', '0').css('bottom', arrow_start);

	$(window).load(function(){

		window.setTimeout(function(){
			arrow.animate({
				'opacity': 1,
				'bottom': arrow_end - 10,
				'easing': 'easeOutExpo'
			}, 200, function(){
				arrow.animate({
					'opacity': 1,
					'bottom': arrow_end,
					'easing': 'easeInExpo'
				}, 100);
			})
		}, 800);


	});
	
	// Widget Functions
	
	if($('.recent').length) {
		$('.recent').each(function(){
			
			var show = parseInt($(this).attr('rel'));
		
			$(this).find('ul').carouFredSel({
				direction: 'up',
				width: "100%",
				height: 'variable',
				circular: false,
				infinite: false,
				items: {
					height: 'variable',
					visible: show
				},
				scroll: {
					items: 1,
					easing: 'easeInOutExpo'
				},
				auto: false,
				prev: $(this).parent().find('.prev'),
				next: $(this).parent().find('.next')
			});
		});
	}
	
	if($('.tweets-widget').length) {
		$('.tweets-widget').each(function(){
		
			var show = parseInt($(this).attr('rel'));
		
			var thisWidget = $(this);
			var twitterID = $(this).find('.tweets-container').attr('id');
			twitterUser = twitterID.split('-');
			twitterUser = twitterUser[0];
			var tweetCount = $(this).find('.tweets-container').html();

			$('.tweets-container').show();
			thisWidget.find('ul').carouFredSel({
				direction: 'up',
				width: "100%",
				height: 'variable',
				circular: false,
				infinite: false,
				items: {
					height: 'variable',
					visible: show
				},
				scroll: {
					items: 1,
					easing: 'easeInOutExpo'
				},
				auto: false,
				prev: $(this).parent().find('.prev'),
				next: $(this).parent().find('.next')
			});
			
		});
	}
	
	if($('.facebook-widget').length) {
		$('.facebook-widget').each(function(){
		
			var show = parseInt($(this).attr('rel'));
		
			$(this).find('ul').carouFredSel({
				direction: 'up',
				width: "100%",
				height: 'variable',
				circular: false,
				infinite: false,
				items: {
					height: 'variable',
					visible: show
				},
				scroll: {
					items: 1,
					easing: 'easeInOutExpo',
					onBefore	: function() {
						$(this).find('object').remove();
						$(this).find('.button-small').fadeIn('normal');
					}
				},
				auto: false,
				prev: $(this).parent().find('.prev'),
				next: $(this).parent().find('.next')
			});
			
		});
	}
	
});

function reset_swiper(){
	
	windowWidth = jQuery(window).width();
	if (windowWidth > 1023){
		swiper_columns = 3;
	} else {
		swiper_columns = 1;
	}
	
	mySwiper = new Swiper('.swiper-container',{
		slidesPerView: swiper_columns,
		slidesPerGroup: swiper_columns
	});
	
}