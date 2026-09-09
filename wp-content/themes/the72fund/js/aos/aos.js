$(document).ready(function() {

	// Example Element
	// <h2 class="main-title aos wiperight" data-animDelay="250" data-animSpeed="750"><?php echo $main_title; ?></h2>
	var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function revealWithoutAnimation() {
		$('.aos').css({
			'animation-delay': '',
			'animation-duration': '',
			'visibility': 'visible'
		}).removeClass('animate').addClass('noDelay');
	}

	function AnimateOnScroll() {
		if (prefersReducedMotion) {
			revealWithoutAnimation();
			return;
		}

		$('.aos').each(function() {
			var $elem = $(this);
			var elemTop = $elem.offset().top;
			// var elemBottom = elemTop + $elem.outerHeight();
			
			var viewportTop = $(window).scrollTop();
			var viewportBottom = viewportTop + $(window).height();

			// Check if the element is in view and above the 100px threshold from the bottom
			if (elemTop < viewportBottom - 50) {
				if (!$elem.hasClass('animate')) {
					var animDelay = parseInt($elem.data('animdelay'), 10);
					var animSpeed = parseInt($elem.data('animspeed'), 10);
			
					// Apply animation delay and duration directly
					$elem.css({
						'animation-delay': `${animDelay}ms`,
						'animation-duration': `${animSpeed}ms`,
						'visibility': 'visible'
					});
			
					$elem.addClass('animate');
				}
			} else {
				$(this).addClass('noDelay');
			}
		});
	}
	
	// Trigger animations on scroll and initially on load
	$(window).on('load', function() {
		if (prefersReducedMotion) {
			revealWithoutAnimation();
			return;
		}

        setTimeout(function() {
			AnimateOnScroll();
			$(window).on('scroll', AnimateOnScroll);
		}, 100);
		$(window).resize(AnimateOnScroll);
    });

	if (prefersReducedMotion) {
		revealWithoutAnimation();
	}

});
  
