/* Custom General jQuery
/*--------------------------------------------------------------------------------------------------------------------------------------*/
;(function($, window, document, undefined) {
	//Genaral Global variables
	//"use strict";
	var $win = $(window);
	var $doc = $(document);
	var $winW = function(){ return $(window).width(); };
	var $winH = function(){ return $(window).height(); };
	var $screensize = function(element){  
			$(element).width($winW()).height($winH());
		};
		
		var screencheck = function(mediasize){
			if (typeof window.matchMedia !== "undefined"){
				var screensize = window.matchMedia("(max-width:"+ mediasize+"px)");
				if( screensize.matches ) {
					return true;
				}else {
					return false;
				}
			} else { // for IE9 and lower browser
				if( $winW() <=  mediasize ) {
					return true;
				}else {
					return false;
				}
			}
		};

	$doc.ready(function() {
/*--------------------------------------------------------------------------------------------------------------------------------------*/		
		// Remove No-js Class
		$("html").removeClass('no-js').addClass('js');
		
		
		
		/* Get Screen size
		---------------------------------------------------------------------*/
		$win.on('load', function(){
			$win.on('resize', function(){
				$screensize('your selector');	
			}).resize();	
		});
		
		
		/* Menu ICon Append prepend for responsive
		---------------------------------------------------------------------*/
		$(window).on('resize', function(){
			if (screencheck(1023)) {
				if(!$('#menu').length){
					$('#mainmenu').prepend('<a href="#" id="menu" class="menulines-button"><span class="menulines"></span></a>');
				}
			} else {
				$("#menu").remove();
			}
		}).resize();



		
		$('.customizer-data-box').click(function() {
			$('.customizer-data-box.active').removeClass('active');
			$(this).addClass('active');
			
		});

		/* Popup function
		---------------------------------------------------------------------*/
		var $dialogTrigger = $('.poptrigger'),
		$pagebody =  $('body');
		$dialogTrigger.click( function(){
			var popID = $(this).attr('data-rel');
			$('body').addClass('overflowhidden');
			var winHeight = $(window).height();
			$('#' + popID).fadeIn();
			var popheight = $('#' + popID).find('.popup-block').outerHeight(true);
			
			if( $('.popup-block').length){
				var popMargTop = popheight / 2;
				//var popMargLeft = ($('#' + popID).find('.popup-block').width()/2);
				
				if ( winHeight > popheight ) {
					$('#' + popID).find('.popup-block').css({
						'margin-top' : -popMargTop,
						//'margin-left' : -popMargLeft
					});	
				} else {
					$('#' + popID).find('.popup-block').css({
						'top' : 0,
						//'margin-left' : -popMargLeft
					});
				}
				
			}
			
			$('#' + popID).append("<div class='modal-backdrop'></div>");
			$('.popouterbox .modal-backdrop').fadeTo("slow", 0.70);
			if( popheight > winHeight ){
				$('.popouterbox .modal-backdrop').height(popheight);
			} 
			$('#' + popID).focus();
			return false;
		});
		
		$(window).on("resize", function () {
			if( $('.popouterbox').length && $('.popouterbox').is(':visible')){
				var popheighton = $('.popouterbox .popup-block').height()+60;
				var winHeight = $(window).height();
				if( popheighton > winHeight ){
					$('.popouterbox .modal-backdrop').height(popheighton);
					$('.popouterbox .popup-block').removeAttr('style').addClass('taller');
					
				} else {
					$('.popouterbox .modal-backdrop').height('100%');
					$('.popouterbox .popup-block').removeClass('taller');
					$('.popouterbox .popup-block').css({
						'margin-top' : -(popheighton/2)
					});
				}	
			}
		});
		
		//Close popup		
		$(document).on('click', '.close-dialogbox, .modal-backdrop', function(){
			$(this).parents('.popouterbox').fadeOut(300, function(){
				$(this).find('.modal-backdrop').fadeOut(250, function(){
					$('body').removeClass('overflowhidden');
					$('.popouterbox .popup-block').removeAttr('style');
					$(this).remove();
				});
			});
			return false;
		});
		
		
		 /*Responsive Menu Dropdown
        -------------------------------------------------------------------*/
        // Add span elements for parent links
        // $('.responsive_menu li.menu-item-has-children').has( "ul" ).prepend('<span></span>');
        // $('.responsive_menu li.menu-item-has-children > a').addClass('closed');

        // // On click show or hide sub menu
        // $('.responsive_menu li.menu-item-has-children span').click(function(e){
        //     // Define variables
        //     var current_span = $(this);
        //     var menus = $('.responsive_menu .sub-menu');
        //     var this_menu = $(this).parent().children('.sub-menu');
        //     var links = $('.menu-item-has-children.open');
        //     var this_link = $(this).next('a');

        //     // Prevent link default action
        //     e.preventDefault();

        //     // Close all open menus excluding this one
        //     // Change open class to closed
        //     if($('.item-has-children').hasClass('open')){
        //         menus.not(this_menu).slideUp();
        //         $(links).not(this_link).removeClass('open').addClass('closed');
        //     }

        //     // Toggle clicked on menu
        //     this_menu.slideToggle();

        //     // Change class appropriately
        //     if(this_link.hasClass('closed')){
        //         this_link.removeClass('closed');
        //         this_link.addClass('open');
        //         current_span.addClass('active');
        //     } else {
        //         this_link.removeClass('open');
        //         this_link.addClass('closed');
        //         current_span.removeClass('active');
        //     }
        // });


		
		/* Tab Content box 
		---------------------------------------------------------------------*/
		var tabBlockElement = $('.tab-data');
			$(tabBlockElement).each(function() {
				var $this = $(this),
					tabTrigger = $this.find(".tabnav li"),
					tabContent = $this.find(".tabcontent");
					var textval = [];
					tabTrigger.each(function() {
						textval.push( $(this).text() );
					});	
				$this.find(tabTrigger).first().addClass("active");
				$this.find(tabContent).first().show();

				
				$(tabTrigger).on('click',function () {
					$(tabTrigger).removeClass("active");
					$(this).addClass("active");
					$(tabContent).hide().removeClass('visible');
					var activeTab = $(this).find("a").attr("data-rel");
					$this.find('#' + activeTab).fadeIn('normal').addClass('visible');
								
					return false;
				});
			
				var responsivetabActive =  function(){
				if (screencheck(767)){
					if( !$('.tabMobiletrigger').length ){
						$(tabContent).each(function(index) {
							$(this).before("<h2 class='tabMobiletrigger'>"+textval[index]+"</h2>");	
							$this.find('.tabMobiletrigger:first').addClass("rotate");
						});
						$('.tabMobiletrigger').click('click', function(){
							var tabAcoordianData = $(this).next('.tabcontent');
							if($(tabAcoordianData).is(':visible') ){
								$(this).removeClass('rotate');
								$(tabAcoordianData).slideUp('normal');
								//return false;
							} else {
								$this.find('.tabMobiletrigger').removeClass('rotate');
								$(tabContent).slideUp('normal');
								$(this).addClass('rotate');
								$(tabAcoordianData).not(':animated').slideToggle('normal');
							}
							return false;
						});
					}
						
				} else {
					if( $('.tabMobiletrigger').length ){
						$('.tabMobiletrigger').remove();
						tabTrigger.removeClass("active");
						$this.find(tabTrigger).removeClass("active").first().addClass('active');
						$this.find(tabContent).hide().first().show();				
					}		
				}
			};
			$(window).on('resize', function(){
				if(!$this.hasClass('only-tab')){
					responsivetabActive();
				}
			}).resize();
		});
		
		/* Accordion box JS
		---------------------------------------------------------------------*/
		$('.accordion-databox').each(function() {
			var $accordion = $(this),
				$accordionTrigger = $accordion.find('.accordion-trigger'),
				$accordionDatabox = $accordion.find('.accordion-data');
				
				// $accordionTrigger.first().addClass('open');
				// $accordionDatabox.first().show();
				
				$accordionTrigger.on('click',function (e) {
					var $this = $(this);
					var $accordionData = $this.next('.accordion-data');
					if( $accordionData.is($accordionDatabox) &&  $accordionData.is(':visible') ){
						$this.removeClass('open');
						$accordionData.slideUp(400);
						e.preventDefault();
					} else {
						if($('.customizer-product-box').find('.accordion-data').is(':visible')) {
							$('.customizer-product-box .accordion-data').slideUp(400);
							$('.customizer-product-box .accordion-trigger').removeClass('open');
						}
						$accordionTrigger.removeClass('open');
						$this.addClass('open');
						$accordionDatabox.slideUp(400);
						$accordionData.slideDown(400);
						
					}
				});
		});
		
		
		/* MatchHeight Js
		-------------------------------------------------------------------------*/
		if($('.customizer-data-box .img-box').length){
			$('.customizer-data-box .img-box').matchHeight();
		}

		if($('.customizer-data p').length){
			$('.customizer-data p').matchHeight({byRow: false});
		}
		
		/*Mobile menu click
		---------------------------------------------------------------------*/
		$(document).on('click',"#menu", function(){
			$(this).toggleClass('menuopen');
			$(this).next('ul').slideToggle('normal');
			return false;
		});
		
		
/*--------------------------------------------------------------------------------------------------------------------------------------*/		
	});	

/*All function nned to define here for use strict mode
----------------------------------------------------------------------------------------------------------------------------------------*/


	
/*--------------------------------------------------------------------------------------------------------------------------------------*/
})(jQuery, window, document);