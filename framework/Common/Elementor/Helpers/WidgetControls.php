<?php
/**
 * Elementor Helper Class: WidgetControls
 *
 * This class contains the widget field controls.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Elementor\Helpers;

use Elementor\Utils;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Elementor Helper Class: WidgetControls
 *
 * @since 1.0.0
 */
class WidgetControls {
	/**
	 * Slider section
	 *
	 * @param object $obj Reference object.
	 *
	 * @return array
	 */
	public static function showcaseSliderControls( $obj ) {
		$fields['slider_section'] = $obj->startSection(
			esc_html__( 'Slider', 'alsiha' ),
		);

		$fields['slides'] = [
			'type'   => 'repeater',
			'label'  => esc_html__( 'Add slides.', 'alsiha' ),
			'mode'   => 'repeater',
			'fields' => [
				'image'       => [
					'type'      => 'media',
					'label'     => esc_html__( 'Upload Slider Image', 'alsiha' ),
					'label_on'  => esc_html__( 'On', 'alsiha' ),
					'label_off' => esc_html__( 'Off', 'alsiha' ),
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
				],

				'custom_link' => [
					'type'        => 'link',
					'label'       => esc_html__( 'Custom Link', 'alsiha' ),
					'placeholder' => esc_html__( '#', 'alsiha' ),
					'options'     => [ 'url', 'is_external', 'nofollow' ],
				],
			],
		];

		$fields['slider_section_end'] = $obj->endSection();

		return $fields;
	}

	/**
	 * Button popup section
	 *
	 * @param object $obj Reference object.
	 *
	 * @return array
	 */
	public static function buttonPopupControls( $obj ) {
		$fields['button_popup_section'] = $obj->startSection(
			esc_html__( 'Slider', 'alsiha' ),
		);

		$fields['buttons'] = [
			'type'   => 'repeater',
			'label'  => esc_html__( 'Add buttons & Popup images.', 'alsiha' ),
			'mode'   => 'repeater',
			'fields' => [
				'text'  => [
					'type'    => 'text',
					'label'   => esc_html__( 'Button Text', 'alsiha' ),
					'default' => esc_html__( 'People', 'alsiha' ),
				],

				'image' => [
					'type'      => 'media',
					'label'     => esc_html__( 'Upload Popup Image', 'alsiha' ),
					'label_on'  => esc_html__( 'On', 'alsiha' ),
					'label_off' => esc_html__( 'Off', 'alsiha' ),
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
				],
			],
		];

		$fields['button_popup_section_end'] = $obj->endSection();

		return $fields;
	}

	/**
	 * Portfolio grid section
	 *
	 * @param object $obj Reference object.
	 *
	 * @return array
	 */
	public static function portfolioGrid( $obj ) {
		$fields['portfolio_grid_section'] = $obj->startSection(
			esc_html__( 'Slider', 'alsiha' ),
		);

		$fields['portfolio_gutter'] = [
			'type'            => 'slider',
			'label'           => esc_html__( 'Select Gutter Size.', 'alsiha' ),
			'mode'            => 'responsive',
			'range'           => [
				'px' => [
					'min'  => 0,
					'max'  => 200,
					'step' => 1,
				],
			],
			'default'         => [
				'size' => 15,
			],
			'desktop_default' => [
				'size' => 15,
				'unit' => 'px',
			],
			'tablet_default'  => [
				'size' => 15,
				'unit' => 'px',
			],
			'mobile_default'  => [
				'size' => 15,
				'unit' => 'px',
			],
			'selectors'       => [
				'{{WRAPPER}}' => 'column-gap:{{SIZE}}{{UNIT}};',
			],
		];

		$fields['include_portfolios'] = [
			'type'        => 'sigma-select2',
			'label'       => esc_html__( 'Include Portfolios', 'alsiha' ),
			'source_name' => 'post_type',
			'source_type' => 'portfolios',
			'multiple'    => true,
			'label_block' => true,
		];

		$fields['portfolio_grid_section_end'] = $obj->endSection();

		return $fields;
	}
}
