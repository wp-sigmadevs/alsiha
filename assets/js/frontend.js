'use strict';

var MFIT = MFIT || {};

/**
 * Predefined variables.
 */
const $ = jQuery,
	$window = $(window),
	$document = $(document),
	$body = $('body'),
	$mainMenu = $('.sf-menu'),
	$handheldMenu = $('.alsiha-menu'),
	$intelHeader = $('.intelligent-header'),
	$preLoader = $('.alsiha-pageloader'),
	$toTop = $('.alsiha-scroll-to-top'),
	$headerSpace = $('.fixed-header-space'),
	$pSlider = $('#primary_slider'),
	$fns = MFIT.functions,
	cartSidebar = {
		container: '.drawer-container',
		close: '.close',
		overlay: '.drawer-overlay',
	};

/**
 * Check if element exists.
 */
$.fn.elExists = function () {
	return this.length > 0;
};

/**
 * Helpers.
 */
MFIT.helpers = {
	sampleFunction() {
		console.log('I am a helper function');
	},
};

/**
 * Functions.
 */
MFIT.functions = {
	preLoaderInit() {
		if (!$preLoader.elExists()) {
			return false;
		}

		$preLoader.delay(300).fadeOut('fast');
	},

	mainNavInit() {
		$mainMenu.superfish({
			delay: 0,
			animation: { opacity: 'show' },
			animationOut: { opacity: 'hide' },
			speed: 'fast',
			autoArrows: false,
			disableHI: true,
		});
	},

	mainNavSubAction() {
		$document.on('mouseenter', '.sf-menu .sub-menu', function () {
			const menu = $(this);
			const child = $(this).find('ul');
			if (
				$(menu).offset().left + $(menu).width() + $(child).width() >
				$(window).width()
			) {
				$(child).css({ left: 'inherit', right: '100%' });
			}
		});
	},

	handheldNavInit() {
		const cButton = document.querySelector('.alsiha-menu__close');
		if (cButton) {
			var slideLeft = new Menu();
		}

		const slideLeftBtn = document.querySelector('#alsiha-trigger-button');
		if (slideLeftBtn) {
			slideLeftBtn.addEventListener('click', function (e) {
				e.preventDefault;
				slideLeft.open();
			});
		}
	},

	handheldNavSubAction() {
		// adds toggle button to li items that have children
		$handheldMenu.find('li a').each(function () {
			if ($(this).next().length > 0) {
				$(this)
					.parent('li')
					.addClass('has-child')
					.append(
						'<a class="drawer-toggle" href="#"><i class="fa fa-angle-down"></i></a>'
					);
			}
		});

		// expands the dropdown menu on each click
		$handheldMenu.find('li .drawer-toggle').on('click', function (e) {
			e.preventDefault();
			$(this)
				.parent('li')
				.children('ul')
				.stop(true, true)
				.slideToggle(250);
			$(this).parent('li').toggleClass('open');
		});
	},

	intelligentMenuInit() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		const navContainer = document.querySelector('.intelligent-header');
		const options = {
			offset: 450,
			classes: {
				initial: 'iheader',
				pinned: 'iheader--pinned',
				unpinned: 'iheader--unpinned',
				top: 'iheader--top',
				notTop: 'iheader--not-top',
				bottom: 'iheader--bottom',
				notBottom: 'iheader--not-bottom',
			},
		};

		const headroom = new Headroom(navContainer, options);

		headroom.init();
	},

	menuClasses() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		$window.on('scroll', function () {
			const height = $window.scrollTop();

			if (height < 100) {
				$intelHeader.removeClass('scrolling');
			} else {
				$intelHeader.addClass('scrolling');
			}
		});
	},

	footerTitleHeight() {
		const $footerTitle = $('.footer-top-column .widgettitle');
		const height = $footerTitle.innerHeight();

		$footerTitle.each(function () {
			$(this).css({
				height,
			});
		});
	},

	scrollToTop() {
		$toTop.hide();
		$window.on('scroll', function () {
			if ($window.scrollTop() > 200) {
				$toTop.fadeIn();
			} else {
				$toTop.fadeOut();
			}
		});

		$toTop.on('click', function () {
			$('html,body').animate(
				{
					scrollTop: 0,
				},
				{
					duration: 500,
					easing: 'swing',
				}
			);
		});
	},

	bodyClass() {
		$body.addClass('document-loaded');
	},

	headerActions() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		const intHeight = $intelHeader[0].getBoundingClientRect().height;
		$headerSpace.height(intHeight);
	},

	showcaseSlider() {
		if (!$pSlider.elExists()) {
			return false;
		}

		const interleaveOffset = 0.5;

		const swiperOptions = {
			loop: true,
			speed: 1000,
			effect: 'slide',
			disableOnInteraction: true,
			watchSlidesProgress: true,
			mousewheelControl: true,
			keyboardControl: true,

			autoplay: {
				delay: 7000,
			},

			navigation: {
				nextEl: '.swiper-arrow.next.slide',
				prevEl: '.swiper-arrow.prev.slide',
			},

			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},

			on: {
				progress() {
					const swiper = this;
					for (let i = 0; i < swiper.slides.length; i++) {
						const slideProgress = swiper.slides[i].progress;
						const innerOffset = swiper.width * interleaveOffset;
						const innerTranslate = slideProgress * innerOffset;
						swiper.slides[i].querySelector(
							'.slide-inner'
						).style.transform =
							'translate3d(' + innerTranslate + 'px, 0, 0)';
					}
				},
				touchStart() {
					const swiper = this;
					for (let i = 0; i < swiper.slides.length; i++) {
						swiper.slides[i].style.transition = '';
					}
				},
				setTransition(speed) {
					const swiper = this;
					for (let i = 0; i < swiper.slides.length; i++) {
						swiper.slides[i].style.transition = speed + 'ms';
						swiper.slides[i].querySelector(
							'.slide-inner'
						).style.transition = speed + 'ms';
					}
				},
			},
		};

		const swiper = new Swiper($pSlider, swiperOptions);
	},

	closeCartSidebar() {
		$(''.concat(cartSidebar.container, ' ').concat(cartSidebar.close)).on(
			'click',
			function (e) {
				MFIT.functions.closeSidebar();
			}
		);

		$(cartSidebar.overlay).on('click', MFIT.functions.closeSidebar);
	},

	closeSidebar() {
		$(cartSidebar.container).removeClass('show-sidebar');
		$('body').removeClass('sidebar-open');
		$('.close.filter-drawer').trigger('click');
		$(cartSidebar.overlay).animate(
			{
				opacity: 0,
			},
			300,
			'swing',
			function () {
				$(cartSidebar.overlay).hide();
			}
		);
	},

	openCart() {
		$(cartSidebar.container).addClass('show-sidebar');
		$('body').addClass('sidebar-open');
		$(cartSidebar.overlay).show('fast', function () {
			$(cartSidebar.overlay).animate(
				{
					opacity: 0.5,
				},
				300,
				'swing'
			);
		});
		MFIT.functions.cartContent();
	},

	cartContent() {
		$.ajax({
			url: alsihaSettings.ajaxurl,
			data: {
				action: 'load_template',
				template: 'cart/mini',
				part: 'cart',
			},
			type: 'POST',
			success: function success(data) {
				$('#side-content-area-id').html(data);
			},
			error: function error(MLHttpRequest, textStatus, errorThrown) {
				console.log(errorThrown);
			},
		});
	},

	openCartSidebar() {
		$(
			'#masthead .action-buttons li.cart-btn a, .mobile-bar .list-inline > li.cart-btn a'
		).click(function (e) {
			e.preventDefault();
			MFIT.functions.openCart();
		});

		$(document).on('added_to_cart', function () {
			MFIT.functions.openCart();
		});
	},

	removeFromCart() {
		$(document).on('removed_from_cart', MFIT.functions.cartContent);
	},

	accordion() {
		if (!$('.alsiha-shop-sidebar').elExists()) {
			return false;
		}

		const firstEl = document.getElementsByClassName('accordion-toggle')[0];
		firstEl.classList.add('active');
		firstEl.nextElementSibling.style.maxHeight =
			firstEl.nextElementSibling.scrollHeight + 'px';

		const acc = document.getElementsByClassName('accordion-toggle');
		let i;

		for (i = 0; i < acc.length; i++) {
			acc[i].onclick = function () {
				const panel = this.nextElementSibling;
				const accPanel =
					document.getElementsByClassName('accordion-content');
				const accToggle =
					document.getElementsByClassName('accordion-toggle');
				const accToggleActive = document.getElementsByClassName(
					'accordion-toggle active'
				);

				if (panel.style.maxHeight) {
					panel.style.maxHeight = null;
					this.classList.remove('active');
				} else {
					for (let ii = 0; ii < accToggleActive.length; ii++) {
						accToggleActive[ii].classList.remove('active');
					}

					for (let iii = 0; iii < accPanel.length; iii++) {
						this.classList.remove('active');
						accPanel[iii].style.maxHeight = null;
					}

					panel.style.maxHeight = panel.scrollHeight + 'px';
					this.classList.add('active');
				}
			};
		}
	},

	stickySidebar() {
		if (!$('#secondary.widget-area').elExists()) {
			return false;
		}

		$('#secondary.widget-area').stickySidebar({
			topSpacing: 20,
			bottomSpacing: 20,
		});
	},

	tooltips() {
		if (!$('.alsiha-buttons .action-btn').elExists()) {
			return false;
		}

		$('.alsiha-buttons .action-btn[title]').tipsy();
	},

	wishlistActions() {
		$(document).on('click', '.alsiha-wishlist-icon', function () {
			if ($(this).hasClass('alsiha-add-to-wishlist')) {
				var $obj = $(this),
					productId = $obj.data('product-id'),
					afterTitle = $obj.data('title-after');
				var data = {
					action: 'alsiha_add_to_wishlist',
					nonce: $obj.data('nonce'),
					add_to_wishlist: productId,
				};
				$.ajax({
					url: alsihaSettings.ajaxurl,
					type: 'POST',
					data,
					beforeSend: function beforeSend() {
						$obj.find('.wishlist-icon').hide();
						$obj.find('.ajax-loading').show();
						$obj.addClass('alsiha-wishlist-ajaxloading');
					},
					success: function success(data) {
						if (data.result != 'error') {
							$obj.find('.ajax-loading').hide();
							$obj.removeClass('alsiha-wishlist-ajaxloading');
							$obj.removeClass('alsiha-add-to-wishlist').addClass(
								'alsiha-remove-from-wishlist'
							);
							$obj.parent().attr('original-title', afterTitle);
							$('body').trigger('alsiha_added_to_wishlist', [
								productId,
							]);
						} else {
							console.log(data.message);
						}
					},
				});
				return false;
			} else if ($(this).hasClass('alsiha-remove-from-wishlist')) {
				var $obj = $(this),
					productId = $obj.data('product-id'),
					afterTitle = $obj.data('title-after');
				var data = {
					action: 'alsiha_remove_from_wishlist',
					context: 'frontend',
					nonce: $obj.data('nonce'),
					remove_from_wishlist: productId,
				};
				$.ajax({
					url: alsihaSettings.ajaxurl,
					type: 'POST',
					data,
					beforeSend: function beforeSend() {
						$obj.find('.wishlist-icon').hide();
						$obj.find('.ajax-loading').show();
						$obj.addClass('alsiha-wishlist-ajaxloading');
					},
					success: function success(data) {
						if (data.result != 'error') {
							$obj.find('.ajax-loading').hide();
							$obj.removeClass('alsiha-wishlist-ajaxloading');
							$obj.removeClass(
								'alsiha-remove-from-wishlist'
							).addClass('alsiha-add-to-wishlist');
							$obj.parent().attr(
								'original-title',
								'Zur Wunschliste hinzufügen'
							);
							$('body').trigger('alsiha_removed_from_wishlist', [
								productId,
							]);
						} else {
							console.log(data.message);
						}
					},
				});

				return false;
			}
		});

		$('body').on('alsiha_added_to_wishlist', function (e, product_id) {
			$('.wishlist-icon-num').html(
				Number.parseInt($('.wishlist-icon-num').html()) + 1
			);
		});
		$('body').on('alsiha_removed_from_wishlist', function (e, product_id) {
			$('.wishlist-icon-num').html(
				Number.parseInt($('.wishlist-icon-num').html()) - 1
			);
		});
	},

	quantityChange() {
		$(document).on(
			'click',
			'.quantity .input-group-btn .quantity-btn',
			function () {
				const $input = $(this).closest('.quantity').find('.input-text');

				if ($(this).hasClass('quantity-plus')) {
					$input.trigger('stepUp').trigger('change');
				}

				if ($(this).hasClass('quantity-minus')) {
					$input.trigger('stepDown').trigger('change');
				}
			}
		);
	},

	wcTabClass() {
		const $target = $('.woocommerce-tabs.wc-tabs-wrapper');

		if (!$target.elExists()) {
			return false;
		}

		$target.find('#tab-description').addClass('active');

		$('body').on('click', '.woocommerce-tabs ul.tabs li a', function (e) {
			const id = $(this).parent().attr('aria-controls');
			$target.find('.woocommerce-Tabs-panel').removeClass('active');
			$target.find('#' + id).addClass('active');
		});
	},

	mobileActions() {
		$('body').on(
			'click',
			'.mobile-bar .list-inline > li.login-btn > a',
			function (e) {
				e.preventDefault();
				$('body')
					.removeClass('mobile-search-active')
					.toggleClass('mobile-popup-active');
				$('body')
					.find('.mobile-search-overlay')
					.removeClass('overlay-active');
				$(this)
					.parents()
					.find($('.mobile-bar .list-inline > li'))
					.removeClass('active');
				$('#mobile-search').fadeOut('fast');
				$(this).next().fadeToggle('fast');
			}
		);

		$('body').on(
			'click',
			'.mobile-bar .list-inline > li.search-btn > a',
			function (e) {
				e.preventDefault();
				$('body')
					.removeClass('mobile-popup-active')
					.toggleClass('mobile-search-active');
				$('body')
					.find('.mobile-search-overlay')
					.toggleClass('overlay-active');
				$(this)
					.parents()
					.find($('.mobile-bar .list-inline > li'))
					.removeClass('active');
				$(
					'.mobile-bar .list-inline > li.login-btn .login-expanded'
				).fadeOut('fast');
				$('#mobile-search').fadeToggle('fast');
			}
		);

		$('body').on(
			'click',
			'.mobile-search-overlay, #mobile-search .close-btn',
			function (e) {
				e.preventDefault();
				$('body')
					.removeClass('mobile-search-active')
					.removeClass('mobile-popup-active');
				$('.mobile-search-overlay').removeClass('overlay-active');
				$(this)
					.parents()
					.find($('.mobile-bar .list-inline > li'))
					.removeClass('active');
				$('#mobile-search').fadeOut('fast');
			}
		);
	},
};

/**
 * Scripts to run on document ready event.
 */
MFIT.onReady = function () {
	const fns = MFIT.functions;

	$document.on('ready', function () {
		fns.preLoaderInit();
		fns.mainNavInit();
		fns.mainNavSubAction();
		fns.handheldNavInit();
		fns.handheldNavSubAction();
		fns.intelligentMenuInit();
		fns.menuClasses();
		fns.scrollToTop();
		fns.headerActions();
		fns.footerTitleHeight();
		fns.showcaseSlider();
		fns.openCartSidebar();
		fns.closeCartSidebar();
		fns.removeFromCart();
		fns.accordion();
		// fns.stickySidebar();
		fns.tooltips();
		fns.wishlistActions();
		fns.quantityChange();
		fns.wcTabClass();
		fns.mobileActions();
	});
};

/**
 * Scripts to run on window load event.
 */
MFIT.onLoad = function () {
	const fns = MFIT.functions;

	$window.on('load', function () {
		fns.bodyClass();
	});
};

/**
 * Scripts to run on window resize event.
 */
MFIT.onResize = function () {
	const fns = MFIT.functions;

	$window.on('resize', function () {
		fns.headerActions();
		fns.footerTitleHeight();
	});
};

/**
 * App Init.
 */
MFIT.init = (function () {
	MFIT.onReady(), MFIT.onLoad(), MFIT.onResize();
})();
