jQuery(document).ready(function($) {

	// Match page offset to fixed header height =================================

	function applyHeaderOffset() {
		var $header = $('#header');
		var $pageContent = $('.page-content');

		if (!$header.length || !$pageContent.length) {
			return;
	}

		$pageContent.css('padding-top', $header.outerHeight() + 'px');
	}

	applyHeaderOffset();

	$(window).on('load resize orientationchange', applyHeaderOffset);

	if ('ResizeObserver' in window) {
		var headerOffsetObserver = new ResizeObserver(applyHeaderOffset);
		var header = $('#header').get(0);

		if (header) {
			headerOffsetObserver.observe(header);
		}
	}

	// Hero Arrow Target =================================

	function updateHeroArrowTarget() {
		var $arrow = $('section.hero .arrow');

		if (!$arrow.length) {
			return;
		}

		var target = window.matchMedia('(max-width: 600px)').matches ? $arrow.data('mobile-target') : $arrow.data('desktop-target');

		if (target) {
			$arrow.attr('href', target);
		}
	}

	updateHeroArrowTarget();

	$(window).on('load resize orientationchange', updateHeroArrowTarget);

	// Static WC Background =================================

	function updateStaticWcBg() {
		var $bg = $('.static-WC_BG');
		var $pageContent = $('.page-content');

		if (!$bg.length || !$pageContent.length) {
			return;
		}

		var scrollTop = $(window).scrollTop();
		var contentTop = $pageContent.offset().top;
		var contentHeight = $pageContent.outerHeight();
		var startTopPercent = parseFloat($bg.attr('data-start-top'));
		var movementPercent = parseFloat($bg.attr('data-movement'));
		var defaultMovementPercent = 8;
		var movement = isNaN(movementPercent) ? defaultMovementPercent : movementPercent;
		var startTop = isNaN(startTopPercent) ? defaultMovementPercent : startTopPercent;
		var travelPercent = Math.max(startTop, movement);
		var startTopPx = contentHeight * (startTop / 100);
		var travelPx = contentHeight * (travelPercent / 100);
		var fixedTopPx = startTopPx - travelPx;
		var startDocumentTop = contentTop + startTopPx;

		var shouldFix = scrollTop >= startDocumentTop - fixedTopPx;

		$bg
			.toggleClass('is-fixed', shouldFix)
			.css('top', shouldFix ? fixedTopPx + 'px' : startTopPx + 'px');
	}

	updateStaticWcBg();

	$(window).on('load scroll resize orientationchange', updateStaticWcBg);

	// Slicknav =================================

	var $slicknav = $('#slicknav');
	var $slicknavOverlay = $('.slicknav-overlay');
	var $slicknavOpen = $('.slicknav-open');
	var $slicknavClose = $('.slicknav-close');

	function setSlicknavFocusable(isEnabled) {
		$slicknav.find('a, button, input, select, textarea, [tabindex]').each(function() {
			var $item = $(this);

			if (!$item.data('slicknav-tabindex-stored')) {
				$item.data('slicknav-tabindex-stored', true);
				$item.data('slicknav-tabindex-original', $item.attr('tabindex'));
			}

			if (isEnabled) {
				var originalTabindex = $item.data('slicknav-tabindex-original');

				if (originalTabindex === undefined) {
					$item.removeAttr('tabindex');
				} else {
					$item.attr('tabindex', originalTabindex);
				}
			} else {
				$item.attr('tabindex', '-1');
			}
		});
	}

	function getSlicknavFocusableItems() {
		return $slicknav
			.find('a, button, input, select, textarea, [tabindex]')
			.filter(':visible')
			.filter(function() {
				return !$(this).is('[disabled], [tabindex="-1"]');
			});
	}

	function setSlicknavState(isOpen, returnFocus) {
		$slicknavOverlay.toggleClass('active', isOpen);
		$slicknav.toggleClass('active', isOpen);
		$('body').toggleClass('noscroll', isOpen);

		$slicknavOpen.attr('aria-expanded', isOpen ? 'true' : 'false');
		$slicknav.attr('aria-hidden', isOpen ? 'false' : 'true');

		if (isOpen) {
			$slicknav.removeAttr('inert').prop('inert', false);
			setSlicknavFocusable(true);
			$slicknavClose.trigger('focus');
		} else {
			$slicknav.attr('inert', '').prop('inert', true);
			setSlicknavFocusable(false);

			if (returnFocus) {
				$slicknavOpen.trigger('focus');
			}
		}
	}

	$slicknavOpen.on('click', function(event) {
		event.preventDefault();
		setSlicknavState(true, false);
	});

	$slicknavClose.add($slicknavOverlay).on('click', function(event) {
		event.preventDefault();
		setSlicknavState(false, true);
	});

	$(document).on('keydown', function(event) {
		if (event.key === 'Escape' && $slicknav.hasClass('active')) {
			setSlicknavState(false, true);
		}
	});

	$slicknav.on('keydown', function(event) {
		if (event.key !== 'Tab' || !$slicknav.hasClass('active')) {
			return;
		}

		var $focusableItems = getSlicknavFocusableItems();

		if (!$focusableItems.length) {
			event.preventDefault();
			return;
		}

		var firstItem = $focusableItems.get(0);
		var lastItem = $focusableItems.get($focusableItems.length - 1);

		if (event.shiftKey && document.activeElement === firstItem) {
			event.preventDefault();
			$(lastItem).trigger('focus');
		} else if (!event.shiftKey && document.activeElement === lastItem) {
			event.preventDefault();
			$(firstItem).trigger('focus');
		}
	});

	setSlicknavFocusable(false);

	// $('.mega-sub-menu').addClass('white-text');

	$('.gform_button').addClass('btn black-btn white-hvr');
	$('.gform_widget .gform_button').removeClass('black-btn white-hvr'); 
	// $('.mega-sub-menu .gform_button').addClass('small-btn');

	// Empty Paragraph Spacers =================================

	$('p').each(function() {
		var paragraphContent = $(this).html()
			.replace(/&nbsp;/gi, '')
			.replace(/\u00a0/g, '')
			.replace(/<br\s*\/?>/gi, '')
			.trim();

		if (!paragraphContent) {
			$(this).addClass('empty-space-paragraph');
		}
	});

	// Section Custom Spacing =================================

	function applyResponsiveSpacing() {

		var w = $(window).width();

		// Section margins (set on <section> when enabled)
		$('section[data-top-margin-desktop], section[data-bottom-margin-desktop]').each(function() {

			var section = $(this);

			var topDesktop = section.data('top-margin-desktop');
			var botDesktop = section.data('bottom-margin-desktop');
			var topMobile  = section.data('top-margin-mobile');
			var botMobile  = section.data('bottom-margin-mobile');

			// If the toggle is OFF, do nothing and let CSS win.
			if (topDesktop === undefined && botDesktop === undefined) {
				return;
			}

			var useMobile = false;

			if (section.hasClass('mobile600')) {
				useMobile = (w <= 600);
			} else if (section.hasClass('mobile850')) {
				useMobile = (w <= 850);
			} else {
				// No breakpoint class found; default to desktop values
				useMobile = false;
			}

			// Apply values; if a value is empty, clear inline so CSS can take over.
			section.css({
				'margin-top': (useMobile ? topMobile : topDesktop) !== undefined && (useMobile ? topMobile : topDesktop) !== '' ? (useMobile ? topMobile : topDesktop) + 'px' : '',
				'margin-bottom': (useMobile ? botMobile : botDesktop) !== undefined && (useMobile ? botMobile : botDesktop) !== '' ? (useMobile ? botMobile : botDesktop) + 'px' : ''
			});
		});

		// Container padding (set on .container when enabled)
		$('.container[data-top-padding-desktop], .container[data-bottom-padding-desktop]').each(function() {

			var container = $(this);

			var topDesktop = container.data('top-padding-desktop');
			var botDesktop = container.data('bottom-padding-desktop');
			var topMobile  = container.data('top-padding-mobile');
			var botMobile  = container.data('bottom-padding-mobile');

			// If the toggle is OFF, do nothing and let CSS win.
			if (topDesktop === undefined && botDesktop === undefined) {
				return;
			}

			var useMobile = false;

			if (container.parent('section.mobile600').length) {
				useMobile = (w <= 600);
			} else if (container.parent('section.mobile850').length) {
				useMobile = (w <= 850);
			} else {
				// No breakpoint class found; default to desktop values
				useMobile = false;
			}

			// Apply values; if a value is empty, clear inline so CSS can take over.
			container.css({
				'padding-top': (useMobile ? topMobile : topDesktop) !== undefined && (useMobile ? topMobile : topDesktop) !== '' ? (useMobile ? topMobile : topDesktop) + 'px' : '',
				'padding-bottom': (useMobile ? botMobile : botDesktop) !== undefined && (useMobile ? botMobile : botDesktop) !== '' ? (useMobile ? botMobile : botDesktop) + 'px' : ''
			});
		});
	}

	// Initial + debounced resize
	var spacingResizeTimer = null;
	applyResponsiveSpacing();

	$(window).on('resize', function(){
		clearTimeout(spacingResizeTimer);
		spacingResizeTimer = setTimeout(applyResponsiveSpacing, 100);
	});

	function getSlickDotButton(label, index) {
		return '<button type="button" aria-label="' + label + ' ' + (index + 1) + '"></button>';
	}

	// Logo Carousel =================================

	function updateLogoCarousel() {
		if (typeof $.fn.slick === 'undefined') {
			return;
		}

		$('section.logos .section-block').each(function() {
			var $carousel = $(this);
			var slideCount = $carousel.find('.section-part').not('.slick-cloned').length;
			var shouldUseCarousel = window.matchMedia('(max-width: 767px)').matches && slideCount > 1;

			if (shouldUseCarousel && !$carousel.hasClass('slick-initialized')) {
				$carousel.slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					centerMode: true,
					centerPadding: '40px',
					variableWidth: true,
					arrows: false,
					dots: true,
					customPaging: function(slider, index) {
						return getSlickDotButton('Go to logo', index);
					},
					adaptiveHeight: false,
					speed: 500,
					swipeToSlide: true,
					touchThreshold: 10
				});
			} else if (!shouldUseCarousel && $carousel.hasClass('slick-initialized')) {
				$carousel.slick('unslick');
			}
		});
	}

	var logoCarouselResizeTimer = null;
	updateLogoCarousel();

	$(window).on('load resize orientationchange', function() {
		clearTimeout(logoCarouselResizeTimer);
		logoCarouselResizeTimer = setTimeout(updateLogoCarousel, 100);
	});

	// Columns Carousel =================================

	function updateColumnsCarousel() {
		if (typeof $.fn.slick === 'undefined') {
			return;
		}

		$('section.columns.has-mobile-carousel .section-block').each(function() {
			var $carousel = $(this);
			var slideCount = $carousel.find('.section-part').not('.slick-cloned').length;
			var shouldUseCarousel = window.matchMedia('(max-width: 767px)').matches && slideCount > 1;

			if (shouldUseCarousel && !$carousel.hasClass('slick-initialized')) {
				$carousel.slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					dots: true,
					customPaging: function(slider, index) {
						return getSlickDotButton('Go to slide', index);
					},
					adaptiveHeight: true,
					speed: 500,
					swipeToSlide: true,
					touchThreshold: 10
				});
			} else if (!shouldUseCarousel && $carousel.hasClass('slick-initialized')) {
				$carousel.slick('unslick');
			}
		});
	}

	var columnsCarouselResizeTimer = null;
	updateColumnsCarousel();

	$(window).on('load resize orientationchange', function() {
		clearTimeout(columnsCarouselResizeTimer);
		columnsCarouselResizeTimer = setTimeout(updateColumnsCarousel, 100);
	});

	// Latest Insights Carousel =================================

	function updateLatestInsightsCarousel() {
		if (typeof $.fn.slick === 'undefined') {
			return;
		}

		$('section.latest-insights .section-block').each(function() {
			var $carousel = $(this);
			var hasDesktopCarousel = $carousel.closest('section.latest-insights').hasClass('has-related-carousel');
			var slideCount = $carousel.find('.section-part').not('.slick-cloned').length;
			var isMobile = window.matchMedia('(max-width: 767px)').matches;
			var shouldUseCarousel = (hasDesktopCarousel && slideCount > 3) || (isMobile && slideCount > 1);

			if (shouldUseCarousel && !$carousel.hasClass('slick-initialized')) {
				$carousel.slick({
					slidesToShow: 3,
					slidesToScroll: 1,
					arrows: true,
					dots: false,
					prevArrow: '<button class="slick-prev" type="button" aria-label="Previous insight"></button>',
					nextArrow: '<button class="slick-next" type="button" aria-label="Next insight"></button>',
					customPaging: function(slider, index) {
						return getSlickDotButton('Go to insight', index);
					},
					adaptiveHeight: false,
					speed: 500,
					swipeToSlide: true,
					touchThreshold: 10,
					responsive: [
						{
							breakpoint: 768,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1,
								arrows: false,
								dots: true,
								adaptiveHeight: true
							}
						}
					]
				});
			} else if (!shouldUseCarousel && $carousel.hasClass('slick-initialized')) {
				$carousel.slick('unslick');
			}
		});
	}

	var latestInsightsCarouselResizeTimer = null;
	updateLatestInsightsCarousel();

	$(window).on('load resize orientationchange', function() {
		clearTimeout(latestInsightsCarouselResizeTimer);
		latestInsightsCarouselResizeTimer = setTimeout(updateLatestInsightsCarousel, 100);
	});

	// Insight filters =================================

	$(document).on('click', '.section-filters .filter-button', function(event) {
		event.preventDefault();

		var $button = $(this);
		var $dropdown = $button.closest('.filter-dropdown');
		var $menu = $dropdown.find('.filter-menu');
		var isOpen = $button.attr('aria-expanded') === 'true';

		$dropdown.siblings('.filter-dropdown').find('.filter-button').attr('aria-expanded', 'false');
		$dropdown.siblings('.filter-dropdown').find('.filter-menu').attr('hidden', true);

		if (isOpen) {
			$button.attr('aria-expanded', 'false');
			$menu.attr('hidden', true);
		} else {
			$button.attr('aria-expanded', 'true');
			$menu.removeAttr('hidden');
		}
	});

	$(document).on('click', function(event) {
		if ($(event.target).closest('.section-filters').length) {
			return;
		}

		$('.section-filters .filter-button').attr('aria-expanded', 'false');
		$('.section-filters .filter-menu').attr('hidden', true);
	});

	$(document).on('keydown', '.section-filters .filter-button, .section-filters .filter-menu a', function(event) {
		if (event.key !== 'Escape') {
			return;
		}

		var $dropdown = $(this).closest('.filter-dropdown');

		$dropdown.find('.filter-button').attr('aria-expanded', 'false').trigger('focus');
		$dropdown.find('.filter-menu').attr('hidden', true);
	});

	// Post Single - Tooltips =================================

	function closePostIconTooltips() {
		$('.section-icons .section-icon.active')
			.removeClass('active')
			.attr('aria-expanded', 'false')
			.trigger('blur');
	}

	$(document).on('click', '.section-icons .section-icon', function(event) {
		event.preventDefault();
		event.stopPropagation();

		var $icon = $(this);
		var isOpen = $icon.hasClass('active');

		$icon.siblings('.section-icon')
			.removeClass('active')
			.attr('aria-expanded', 'false');

		$icon
			.toggleClass('active', !isOpen)
			.attr('aria-expanded', isOpen ? 'false' : 'true');

		if (isOpen) {
			$icon.trigger('blur');
		}
	});

	$(document).on('click', function(event) {
		if ($(event.target).closest('.section-icons').length) {
			return;
		}

		closePostIconTooltips();
	});

	$(document).on('keydown', '.section-icons .section-icon', function(event) {
		if (event.key !== 'Escape') {
			return;
		}

		closePostIconTooltips();
	});

	// Accordion =================================

	$(document).on('click', '.accordion-initial', function () {
		var $trigger = $(this);
		var $panel = $trigger.next('.accordion-reveal');
		var $group = $trigger.closest('.section-block');
		var isOpen = $trigger.hasClass('active');

		if (!$group.length) {
			$group = $trigger.parent();
		}

		if (isOpen) {
			$trigger.removeClass('active').attr('aria-expanded', 'false');
			$panel.slideUp('fast', function () {
				$panel.attr('hidden', true);
			});
		} else {
			$group.find('.accordion-initial.active')
				.removeClass('active')
				.attr('aria-expanded', 'false');

			$group.find('.accordion-reveal').slideUp('fast', function () {
				$(this).attr('hidden', true);
			});

			$trigger.addClass('active').attr('aria-expanded', 'true');
			$panel.removeAttr('hidden').slideDown('fast');
		}
	});

	$(document).on('keydown', '.accordion-initial', function (event) {
		if (event.key === 'Enter' || event.key === ' ') {
			event.preventDefault();
			$(this).trigger('click');
		}
	});

	function openAccordionFromHash(hash) {
		if (!hash) {
			return $();
		}

		var target = document.getElementById(hash.substring(1));

		if (!target) {
			return $();
		}

		var $target = $(target);
		var $trigger = $target.hasClass('accordion-initial') ? $target : $target.find('.accordion-initial').first();

		if (!$trigger.length) {
			return $target;
		}

		if (!$trigger.hasClass('active')) {
			$trigger.trigger('click');
		}

		return $target;
	}
	
	// Smooth scrolling to anchor =================================
	
	// On same page
	$('a[href*="#"]').on('click', function(event) {
		if (this.hash && $(this.hash).length) {
			event.preventDefault();
			var hash = this.hash;
			var $target = openAccordionFromHash(hash);

			if (!$target.length) {
				$target = $(hash);
			}

			$('html, body').animate({
				scrollTop: $target.offset().top - 90
			}, 1000, function() {
				// window.location.hash = hash; // updates the URL with hash value to match the link's hash (had some jank with this)
			});
		}
	});

	// When page loads with hash value (eg. linking from another page)
	if (window.location.hash) {
		var hash = window.location.hash;
		if ($(hash).length) {
			var $target = openAccordionFromHash(hash);

			if (!$target.length) {
				$target = $(hash);
			}

			$('html, body').animate({
				scrollTop: $target.offset().top - 90
			}, 1000);
		}
	}
	
});
