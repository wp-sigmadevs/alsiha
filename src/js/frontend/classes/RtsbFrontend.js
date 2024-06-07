/**
 * A class that handles frontend functionality for the ShopBuilder plugin.
 *
 * @class RtsbFrontend
 *
 * @param {jQuery} $ - The jQuery object.
 */

/* global rtsbToastr, rtsbPublicParams */

import { rtsbFrontendHelpers as helpers } from '../helpers';
import { rtsbAddToCart, rtsbCartQuantity } from '../components/add-to-cart';
import {
	rtsbVariationHandler,
	rtsbVariationReset,
} from '../components/variation-actions';
import { rtsbAddCartIcon } from '../components/add-cart-icon';
import { rtsbReviewFormStar } from '../components/review-form-star';
import { rtsbProductImage } from '../components/product-image';
import {
	rtsbCheckoutCoupon,
	rtsbCheckoutError,
	rtsbLoginForm,
} from '../components/checkoutpage';
import { RtsbElFrontend } from './RtsbElFrontend';
import { rtsbDeviceBreak } from '../components/responsive-check';
import { rtsbProductTabs } from '../components/product-tabs';
import { rtsbCartTableResponsive } from '../components/cart-page';

export class RtsbFrontend {
	/**
	 * Constructor for RtsbFrontend class
	 *
	 * @param {jQuery} $ - jQuery object
	 */
	constructor($) {
		this.$ = $;
	}

	/**
	 * Initializes the RtsbFrontend class when the DOM is ready.
	 *
	 * @function
	 */
	domReady() {
		this.initGlobalVar();
		this.initTooltip();
		this.initToastr();
		this.addToCartAction();
		this.socialShare();
		this.checkoutPageInit();
		this.cartPageInit();
		this.triggerExecute();
	}

	/**
	 * Initializes the RtsbFrontend class when the DOM is loaded.
	 *
	 * @function
	 */
	domLoad() {
		this.fixBuilderJumping();
	}

	/**
	 * Initializes the RtsbFrontend class when the DOM is resized.
	 *
	 * @function
	 */
	domResize() {
		this.cartPageInit();
	}

	/**
	 * Initializes global variables.
	 *
	 * @function
	 */
	initGlobalVar() {
		window.rtsbDeviceCheck = (width) => rtsbDeviceBreak(this.$, width);
		window.rtsbElFrontend = () => new RtsbElFrontend(this.$);
		window.rtsbProductPageInit = () => this.productPageInit(this.$);

		// Init
		window.rtsbElFrontend();
		window.rtsbProductPageInit();
	}

	/**
	 * Initializes tooltips.
	 *
	 * @function
	 */
	initTooltip() {
		this.$('a[rel=tipsy], a.tipsy, button.tipsy').each((i, el) => {
			const $this = this.$(el);
			const position = $this
				.closest('.rtsb-elementor-container, .rtsb-tipsy-position')
				.attr('data-tooltip-position');
			let dataDirection =
				$this.parent().attr('data-tooltip-direction') || 'top';

			if (typeof position !== 'undefined' && position !== false) {
				dataDirection = position;
			}

			helpers.tooltips($this, dataDirection);

			this.$(document).on('rtsb-ajax-success', () => {
				helpers.tooltips($this, dataDirection);
			});
		});
	}

	/**
	 * Initializes toastr.
	 *
	 * @function
	 */
	initToastr() {
		window.rtsbToastr = require('toastr');

		rtsbToastr.options.closeButton = true;
		rtsbToastr.options.positionClass =
			'toast-' + (rtsbPublicParams.notice.position || 'center-center');

		if (this.$('body').hasClass('rtsb-notifications-hidden')) {
			rtsbToastr.options.target = null;
		}
	}

	/**
	 * Adds an item to the cart.
	 *
	 * @function
	 */
	addToCartAction() {
		// Simple Products.
		this.$(document).on(
			'click',
			'.rtsb-elementor-container .rtsb-add-to-cart-btn',
			(event) => {
				rtsbAddToCart(this.$, event);
			}
		);

		// Variable Products.
		this.handleVariationActions();
	}

	/**
	 * Handles social sharing.
	 *
	 * @function
	 */
	socialShare() {
		this.$(document).on(
			'click',
			'.rtsb-share-btn[target="_blank"]',
			function (event) {
				event.preventDefault();

				const url = this.href,
					domain = url.split('/')[2];

				let windowSize = {};
				switch (domain) {
					case 'www.facebook.com':
						windowSize = { width: 585, height: 368 };
						break;
					case 'twitter.com':
						windowSize = { width: 585, height: 361 };
						break;
					case 'pinterest.com':
						windowSize = { width: 750, height: 550 };
						break;
					default:
						windowSize = { width: 585, height: 515 };
				}

				let left = (window.innerWidth - windowSize.width) / 2;
				let top = (window.innerHeight - windowSize.height) / 2;

				left = Math.max(0, left);
				top = Math.max(0, top);

				const windowFeatures =
					'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,' +
					'width=' +
					windowSize.width +
					',height=' +
					windowSize.height +
					',left=' +
					left +
					',top=' +
					top;

				window.open(url, '', windowFeatures);
			}
		);
	}

	/**
	 * Initializes the product page.
	 *
	 * @function
	 */
	productPageInit() {
		rtsbAddCartIcon(this.$);
		rtsbReviewFormStar(this.$);
		rtsbProductImage(this.$);
		rtsbProductTabs(this.$);
		rtsbCartQuantity(this.$);
	}

	/**
	 * Initializes the checkout page.
	 *
	 * @function
	 */
	checkoutPageInit() {
		rtsbCheckoutCoupon(this.$);
		rtsbLoginForm(this.$);
		rtsbCheckoutError(this.$);
	}

	/**
	 */
	cartPageInit() {
		rtsbCartTableResponsive(this.$);
	}

	/**
	 * Fixes the builder jumping issue.
	 *
	 * @function
	 */
	fixBuilderJumping() {
		this.$('.rtsb-builder-content').removeClass('content-invisible');
	}

	/**
	 * Handles variation add to cart actions.
	 *
	 * @function
	 */
	handleVariationActions() {
		const variationForm = this.$(
			'.rtsb-elementor-container .variations_form'
		);

		variationForm.on(
			'found_variation.rtwpvs-archive-variation',
			{ $: this.$ },
			rtsbVariationHandler
		);
		variationForm.on(
			'click added_to_cart',
			'.rtwpvs_archive_reset_variations',
			{ $: this.$ },
			rtsbVariationReset
		);
	}

	/**
	 * Trigger Execute Point.
	 */
	triggerExecute() {
		this.$(document).on('rtsbQv.success', () => {
			rtsbProductImage(this.$);
		});
	}
}
