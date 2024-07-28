/**
 * Handheld menu JS.
 */

'use strict';

/**
 * Handheld menu class.
 *
 * @class
 */
class SigmaHandheldMenu {
	/**
	 * Creates an instance of Menu.
	 *
	 * @param {Object} options - The options to configure the menu.
	 */
	constructor(options) {
		this.$ = jQuery;
		this.options = {...Menu.defaults, ...options};

		this._init();
	}

	/**
	 * Default options for the Menu.
	 *
	 * @returns {Object} - The default options.
	 */
	static get defaults() {
		return {
			wrapper: '#alsiha-mobile-menu',
			type: 'slide-left',
			menuOpenerClass: '.c-button',
			maskId: '#alsiha-menu-mask'
		};
	}

	/**
	 * Initialize Menu.
	 *
	 * @private
	 * @returns {void}
	 */
	_init = () => {
		this.body = this.$('body');
		this.wrapper = this.$(this.options.wrapper);
		this.mask = this.$(this.options.maskId);
		this.menu = this.$('#alsiha-mobile-menu');
		this.closeBtn = this.menu.find('.alsiha-menu-close');
		this.menuOpeners = this.$(this.options.menuOpenerClass);

		this._initEvents();
	};

	/**
	 * Initialize Menu Events.
	 *
	 * @private
	 * @returns {void}
	 */
	_initEvents = () => {
		// Event for clicks on the close button inside the menu.
		this.closeBtn.on('click', (e) => {
			e.preventDefault();
			this.close();
		});

		// Event for clicks on the mask.
		this.mask.on('click', (e) => {
			e.preventDefault();
			this.close();
		});
	};

	/**
	 * Open Menu.
	 *
	 * @returns {void}
	 */
	open = () => {
		this.body.addClass('has-active-menu');
		this.wrapper.addClass(`has-${this.options.type}`);
		this.menu.addClass('is-active');
		this.mask.addClass('is-active');

		this.disableMenuOpeners();
	};

	/**
	 * Close Menu.
	 *
	 * @returns {void}
	 */
	close = () => {
		this.body.removeClass('has-active-menu');
		this.wrapper.removeClass(`has-${this.options.type}`);
		this.menu.removeClass('is-active');
		this.mask.removeClass('is-active');

		this.enableMenuOpeners();
	};

	/**
	 * Disable Menu Openers.
	 *
	 * @returns {void}
	 */
	disableMenuOpeners = () => {
		this.menuOpeners.prop('disabled', true);
	};

	/**
	 * Enable Menu Openers.
	 *
	 * @returns {void}
	 */
	enableMenuOpeners = () => {
		this.menuOpeners.prop('disabled', false);
	};
}

// Add to global namespace.
window.SigmaHandheldMenu = SigmaHandheldMenu;
