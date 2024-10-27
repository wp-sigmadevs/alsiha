<?php
/**
 * Elementor Helper Class: Select2AjaxControl
 *
 * This class contains the custom Ajax select2 Elementor widget control.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Elementor\Controls;

use Elementor\Base_Data_Control;
use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Elementor Helper Class: Select2AjaxControl
 *
 * @since 1.0.0
 */
class Select2AjaxControl extends Base_Data_Control {
	/**
	 * Set control name.
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	public static $controlName = 'sigma-select2';

	/**
	 * Control Name.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function get_type() {
		return self::$controlName;
	}

	/**
	 * Control assets.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'alsiha-admin-styles' );
		wp_enqueue_script( 'alsiha-admin-script' );
	}

	/**
	 * Default settings.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	protected function get_default_settings() {
		return [
			'multiple'                 => false,
			'label_block'              => true,
			'source_name'              => 'post_type',
			'source_type'              => 'post',
			'minimum_input_length'     => 3,
			'maximum_selection_length' => - 1,
		];
	}

	/**
	 * Content template.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>

		<# var controlUID = '<?php echo esc_html( $control_uid ); ?>'; #>
		<# var currentID = elementor.panel.currentView.currentPageView.model.attributes.settings.attributes[data.name]; #>
		<# var maxSelection = (data.maximum_selection_length > 0) ? 'max-select'+data.maximum_selection_length : 'unlimited-select' #>
		<div class="elementor-control-field sigma-select2-main-wrapper {{maxSelection}}">
			<# if ( data.label ) { #>
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
				<select id="<?php echo esc_attr( $control_uid ); ?>" {{ multiple }} class="sigma-select2" data-setting="{{ data.name }}"></select>
			</div>
			<# if ( data.description ) { #>
			<div class="elementor-control-field-description sigma-description">{{{ data.description }}}</div>
			<# } #>
		</div>
		<#
		(function($) {
			$(document.body).trigger('sd_sigma_elementor_ajax_event', {
				currentID:data.controlValue,
				data:data,controlUID:controlUID,
				multiple:data.multiple
			});
		}(jQuery));
		#>
		<?php
	}
}
