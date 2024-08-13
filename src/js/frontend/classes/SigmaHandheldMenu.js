/**
 * A class that handles mobile menu functionality.
 *
 * @class SigmaHandheldMenu
 */
export class SigmaHandheldMenu {
	/**
	 * jQuery instance for DOM manipulation.
	 *
	 * @type {jQuery}
	 */
	$ = jQuery;

	/**
	 * Constructor for Menu class.
	 * Initializes the menu and sets up event listeners.
	 *
	 * @param {Object} options - Configuration options for the menu.
	 */
	constructor(options) {
		this.options = this.extendDefaults(options);
		this.initializeVars();
		this.initEvents();
	}

	/**
	 * Default Menu Options.
	 *
	 * @param {Object} options - Configuration options for the menu.
	 */
	extendDefaults = (options) => {
		return this.$.extend(
			true,
			{
				wrapper: '#sigma-handheld-menu',
				menu: '#sigma-mobile-menu',
				menuOpenerClass: '.handheld-menu-trigger',
				maskId: '#sigma-menu-mask',
				closeBtn: '.sigma-menu-close',
			},
			options
		);
	};

	/**
	 * Initialize variables and cache DOM elements.
	 *
	 * @function
	 */
	initializeVars = () => {
		this.body = this.$('body');
		this.wrapper = this.$(this.options.wrapper);
		this.mask = this.$(this.options.maskId);
		this.menu = this.$(this.options.menu);
		this.closeBtn = this.wrapper.find(this.options.closeBtn);
		this.menuOpeners = this.$(this.options.menuOpenerClass);
	};

	/**
	 * Initialize Menu Events.
	 *
	 * @function
	 * @private
	 */
	initEvents = () => {
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

		// Event for menu opener buttons.
		this.menuOpeners.on('click', (e) => {
			e.preventDefault();
			this.open();
		});
	};

	/**
	 * Open Menu.
	 *
	 * @function
	 */
	open = () => {
		this.mask.addClass('open');
		setTimeout(() => {
			this.body.addClass('has-active-menu');
			this.menu.addClass('is-active');
			this.disableMenuOpeners();
		}, 300);
	};

	/**
	 * Close Menu.
	 *
	 * @function
	 */
	close = () => {
		this.body.removeClass('has-active-menu');
		this.wrapper.removeClass(`has-${this.options.type}`);
		this.menu.removeClass('is-active');
		this.mask.removeClass('open');
		this.enableMenuOpeners();
	};

	/**
	 * Disable Menu Openers.
	 *
	 * @function
	 * @private
	 */
	disableMenuOpeners = () => {
		this.menuOpeners.prop('disabled', true);
	};

	/**
	 * Enable Menu Openers.
	 *
	 * @function
	 * @private
	 */
	enableMenuOpeners = () => {
		this.menuOpeners.prop('disabled', false);
	};
}
