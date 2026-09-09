jQuery(document).ready(function($) {
	
	// Custom Modal =================================
	var $lastModalTrigger = $();
	var focusableSelector = 'a, button, input, select, textarea, [tabindex]';

	// Function to update modal-block height for each modal (to make them all match heights)
    // function updateModalBlockHeight() {
	// 	$(".custom-modal").each(function() {
	// 		var maxHeight = 0;
	
	// 		// Reset the height to 'auto' before recalculating
	// 		$(this).find(".modal-page").css('height', 'auto');
	
	// 		// Find the tallest modal-page
	// 		$(this).find(".modal-page").each(function() {
	// 			var thisHeight = $(this).outerHeight();
	// 			if (thisHeight > maxHeight) {
	// 				maxHeight = thisHeight;
	// 			}
	// 		});
	
	// 		// Set all modal-pages to the height of the tallest one
	// 		$(this).find(".modal-page").css('height', maxHeight + 'px');
	// 	});
	// }
	// $(window).on('load', function () {
	// 	updateModalBlockHeight(); // Update modal-block height when modal link is clicked
	// });
    // $(window).resize(updateModalBlockHeight); // Update modal-block height whenever window is resized

	// Function to check height and add 'canScroll' class
    function checkModalHeight() {
        $(".modal-block").each(function() {
            var modalBlockHeight = $(this).outerHeight();
            var viewportHeight = $(window).height();

            if (modalBlockHeight > viewportHeight) {
                $(this).addClass('canScroll');
            } else {
                $(this).removeClass('canScroll');
            }
        });
    }
	    $(window).resize(checkModalHeight); // Also check when window is resized

	function getFocusableItems($modal) {
		return $modal
			.find(focusableSelector)
			.filter(':visible')
			.filter(function() {
				return !$(this).is('[disabled], [tabindex="-1"]');
			});
	}

	function setModalFocusable($modal, isEnabled) {
		$modal.find(focusableSelector).each(function() {
			var $item = $(this);

			if (!$item.data('modal-tabindex-stored')) {
				$item.data('modal-tabindex-stored', true);
				$item.data('modal-tabindex-original', $item.attr('tabindex'));
			}

			if (isEnabled) {
				var originalTabindex = $item.data('modal-tabindex-original');

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

	function activateModalPage($modal, target) {
		var $targetPage = $modal.find("#" + target);

		if (!$targetPage.length) {
			return $();
		}

		$modal.find('.modal-page').not($targetPage).removeClass('active').attr('hidden', true).hide();
		$targetPage.addClass('active').removeAttr('hidden').show();

		return $targetPage;
	}

	function openModal(targetModalId, target, $trigger) {
		var $modal = $("#" + targetModalId);

		if (!$modal.length) {
			return;
		}

		$lastModalTrigger = $trigger && $trigger.length ? $trigger : $();

		$modal.addClass('open').attr('aria-hidden', 'false').removeAttr('inert').prop('inert', false);
		setModalFocusable($modal, true);
		activateModalPage($modal, target);

		$("body").addClass('modalNoscroll');
		checkModalHeight();

		var $focusableItems = getFocusableItems($modal);
		var $initialFocus = $modal.find('.modal-close:visible').first();

		if (!$initialFocus.length) {
			$initialFocus = $focusableItems.first();
		}

		if ($initialFocus.length) {
			$initialFocus.trigger('focus');
		}

		window.history.pushState({ path: target }, '', window.location.pathname + '#' + target);
	}

	// Move each modal to the end of <body> and keep closed modals out of the tab order.
	$(".custom-modal").each(function() {
		var $modal = $(this);

		$modal.attr('aria-hidden', 'true').attr('inert', '').prop('inert', true);
		setModalFocusable($modal, false);
		$modal.appendTo('body');
	});

	// Open modal
	$(".modal-link").click(function(e) {
		e.preventDefault();
		var targetModalId = $(this).data('modal-target'); // Assuming you add a data-modal-target attribute to your links
		var target = $(this).data('page-target'); // Assuming you add a data-page-target attribute to your links

		openModal(targetModalId, target, $(this));
	});

		// Open modal via URL
	var hash = window.location.hash;
    if (hash) {
        // Ensure data-page-target matches hash minus the '#'
        var targetModalId = $('.modal-link[data-page-target="' + hash.substring(1) + '"]').data('modal-target');
        var targetPage = hash.substring(1); // Remove the '#' from the hash

	        if (targetModalId && targetPage) {
				openModal(targetModalId, targetPage, $());
	        }

    }

	// Close modal function
	    function closeModal() {
			var $openModal = $(".custom-modal.open");

			$openModal.removeClass('open').attr('aria-hidden', 'true').attr('inert', '').prop('inert', true);
			$openModal.find('.modal-page').removeClass('active').removeAttr('hidden').show();
			setModalFocusable($openModal, false);
	        $("body").removeClass('modalNoscroll'); // Enable scrolling on body

			// Remove the hash from the URL without reloading the page
			window.history.pushState("", document.title, window.location.pathname + window.location.search);

			if ($lastModalTrigger.length && document.body.contains($lastModalTrigger.get(0))) {
				$lastModalTrigger.trigger('focus');
			}
	    }
    // Close modal when clicking the close button
    $(".modal-close").click(function() {
        closeModal();
    });
    // Close modal when clicking outside the modal-block
    $(".custom-modal").click(function(e) {
        if ($(e.target).hasClass('custom-modal')) {
            closeModal();
        }
    });
    // Prevent closing modal when clicking inside the modal-block
    $(".modal-block").click(function(e) {
        e.stopPropagation();
    });

	// Navigate modal pages
		$(".modal-arrow").click(function() {
			var $modal = $(this).closest('.custom-modal');
			var current = $modal.find('.modal-page.active');
			var isNext = $(this).hasClass('next-arrow');
			var next;

			if (isNext) {
				next = current.next('.modal-page');
				if (next.length === 0) { // Loop back to first
					next = $modal.find(".modal-page").first();
				}
			} else {
				next = current.prev('.modal-page');
				if (next.length === 0) { // Loop to last
					next = $modal.find(".modal-page").last();
				}
			}

			current.removeClass('active').attr('hidden', true).hide();
			next.addClass('active').removeAttr('hidden').show();

			// Update the URL hash without reloading the page
			var nextId = next.attr('id');
			window.history.pushState(null, null, '#' + nextId);

			checkModalHeight(); // Check height and add class 'canScroll' if needed
		});

		$(document).on('keydown', function(e) {
			var $openModal = $('.custom-modal.open').last();

			if (!$openModal.length) {
				return;
			}

			if (e.key === 'Escape') {
				e.preventDefault();
				closeModal();
				return;
			}

			if (e.key !== 'Tab') {
				return;
			}

			var $focusableItems = getFocusableItems($openModal);

			if (!$focusableItems.length) {
				e.preventDefault();
				return;
			}

			var firstItem = $focusableItems.get(0);
			var lastItem = $focusableItems.get($focusableItems.length - 1);

			if (!$.contains($openModal.get(0), document.activeElement)) {
				e.preventDefault();
				$(firstItem).trigger('focus');
			} else if (e.shiftKey && document.activeElement === firstItem) {
				e.preventDefault();
				$(lastItem).trigger('focus');
			} else if (!e.shiftKey && document.activeElement === lastItem) {
				e.preventDefault();
				$(firstItem).trigger('focus');
			}
		});

	});
