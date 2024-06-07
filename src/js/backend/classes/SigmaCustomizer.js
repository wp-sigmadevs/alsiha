/**
 * Class representing the customizer functionality.
 */

/* global jQuery, wp */

export class SigmaCustomizer {
	/**
	 * Initializes the customizer.
	 */
	constructor() {
		this.$ = jQuery;

		this.init();
	}

	/**
	 * Initializes customizer settings.
	 *
	 * @returns {void}
	 */
	init = () => {
		// Header text.
		wp.customize('header_textcolor', (value) => {
			value.bind((to) => this.updateHeaderText(to));
		});

		// Colors.
		const colors = ['text', 'primary', 'secondary', 'tertiary', 'offset', 'border'];

		colors.forEach(color => {
			wp.customize(`alsiha_${color}_color`, (value) => {
				value.bind(to => this.updateColor(color, to));
			});
		});
	}

	/**
	 * Updates the header text based on the customizer setting.
	 *
	 * @param {string} to - The new value of the header text color.
	 *
	 * @returns {void}
	 */
	updateHeaderText = (to) => {
		if (to === 'blank') {
			this.$('.site-title a, .site-description').css({
				clip: 'rect(1px, 1px, 1px, 1px)',
				position: 'absolute'
			});

			this.$('body').addClass('title-tagline-hidden');
		} else {
			this.$('.site-title a, .site-description').css({
				clip: 'auto',
				position: 'relative',
				color: to
			});

			this.$('body').removeClass('title-tagline-hidden');
		}
	}

	/**
	 * Updates the CSS variable for the specified color.
	 *
	 * @param {string} color - The color identifier (e.g., 'primary').
	 * @param {string} to - The new value of the color.
	 *
	 * @returns {void}
	 */
	updateColor = (color, to) => {
		document.documentElement.style.setProperty(`--alsiha-${color}-color`, to);
	}
}
