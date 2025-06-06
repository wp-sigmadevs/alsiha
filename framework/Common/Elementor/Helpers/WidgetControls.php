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
			esc_html__( 'Button', 'alsiha' ),
		);

		$fields['buttons'] = [
			'type'        => 'repeater',
			'label'       => esc_html__( 'Add buttons & Popup images.', 'alsiha' ),
			'mode'        => 'repeater',
			'title_field' => '{{{ text }}}',
			'fields'      => [
				'text'  => [
					'type'    => 'text',
					'label'   => esc_html__( 'Button Text', 'alsiha' ),
					'default' => esc_html__( 'People', 'alsiha' ),
				],

				'image' => [
					'type'    => 'media',
					'label'   => esc_html__( 'Upload Popup Image', 'alsiha' ),
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				],
			],
		];

		$fields['button_popup_section_end'] = $obj->endSection();

		return $fields;
	}

	/**
	 * Grid popup section
	 *
	 * @param object $obj Reference object.
	 *
	 * @return array
	 */
	public static function gridPopupControls( $obj ) {
		$fields['grid_popup_section'] = $obj->startSection(
			esc_html__( 'Grids', 'alsiha' ),
		);

		$fields['grid_columns'] = [
			'type'        => 'select',
			'label'       => esc_html__( 'Select Grid Columns.', 'alsiha' ),
			'mode'        => 'responsive',
			'options'     => [
				1 => esc_html__( '1 Column', 'alsiha' ),
				2 => esc_html__( '2 Columns', 'alsiha' ),
				3 => esc_html__( '3 Columns', 'alsiha' ),
				4 => esc_html__( '4 Columns', 'alsiha' ),
				5 => esc_html__( '5 Columns', 'alsiha' ),
				6 => esc_html__( '6 Columns', 'alsiha' ),
			],
			'default'     => 3,
			'label_block' => true,
		];

		$fields['grid_gutter'] = [
			'type'       => 'slider',
			'label'      => esc_html__( 'Select Gutter Size.', 'alsiha' ),
			'mode'       => 'responsive',
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [
				'px'  => [
					'min'  => 0,
					'max'  => 200,
					'step' => 5,
				],
				'em'  => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
				'rem' => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
			],
			'default'    => [
				'size' => 0,
				'unit' => 'rem',
			],
			'separator'  => 'before',
			'selectors'  => [
				'{{WRAPPER}} .sigma-portfolio-grid' => '--alsiha-column-gutter:{{SIZE}}{{UNIT}};',
			],
		];

		$fields['grids'] = [
			'type'        => 'repeater',
			'label'       => esc_html__( 'Add grids & Popup images.', 'alsiha' ),
			'mode'        => 'repeater',
			'title_field' => '{{{ text }}}',
			'separator'   => 'before',
			'fields'      => [
				'text'       => [
					'type'        => 'text',
					'label'       => esc_html__( 'Grid Text', 'alsiha' ),
					'default'     => esc_html__( 'Mango', 'alsiha' ),
					'label_block' => true,
				],
				'grid_image' => [
					'type'      => 'media',
					'label'     => esc_html__( 'Upload Grid Image', 'alsiha' ),
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'separator' => 'before',
				],
				'action'     => [
					'type'        => 'select',
					'label'       => esc_html__( 'Action Type?', 'alsiha' ),
					'options'     => [
						'popup' => esc_html__( 'Image Popup', 'alsiha' ),
						'link'  => esc_html__( 'Open Custom Link', 'alsiha' ),
					],
					'default'     => 'popup',
					'separator'   => 'before',
					'label_block' => true,
				],
				'image'      => [
					'type'      => 'media',
					'label'     => esc_html__( 'Upload Popup Image', 'alsiha' ),
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'action' => 'popup',
					],
					'separator' => 'before',
				],
				'link'       => [
					'type'      => 'url',
					'label'     => esc_html__( 'Enter Custom Link', 'alsiha' ),
					'options'   => false,
					'default'   => [
						'url' => '#',
					],
					'condition' => [
						'action' => 'link',
					],
					'separator' => 'before',
				],
				'new_tab'    => [
					'type'      => 'switch',
					'label'     => esc_html__( 'Open Link in New Tab?', 'alsiha' ),
					'label_on'  => esc_html__( 'On', 'alsiha' ),
					'label_off' => esc_html__( 'Off', 'alsiha' ),
					'condition' => [
						'action' => 'link',
					],
					'separator' => 'before',
				],
			],
		];

		$fields['grid_popup_section_end'] = $obj->endSection();

		return $fields;
	}

	/**
	 * Grid popup section
	 *
	 * @param object $obj Reference object.
	 *
	 * @return array
	 */
	public static function gridPopupGalleryControls( $obj ) {
		$fields['grid_popup_gallery_section'] = $obj->startSection(
			esc_html__( 'Grids', 'alsiha' ),
		);

		$fields['grid_columns'] = [
			'type'        => 'select',
			'label'       => esc_html__( 'Select Grid Columns.', 'alsiha' ),
			'mode'        => 'responsive',
			'options'     => [
				1 => esc_html__( '1 Column', 'alsiha' ),
				2 => esc_html__( '2 Columns', 'alsiha' ),
				3 => esc_html__( '3 Columns', 'alsiha' ),
				4 => esc_html__( '4 Columns', 'alsiha' ),
				5 => esc_html__( '5 Columns', 'alsiha' ),
				6 => esc_html__( '6 Columns', 'alsiha' ),
			],
			'default'     => 3,
			'label_block' => true,
		];

		$fields['grid_gutter'] = [
			'type'       => 'slider',
			'label'      => esc_html__( 'Select Gutter Size.', 'alsiha' ),
			'mode'       => 'responsive',
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [
				'px'  => [
					'min'  => 0,
					'max'  => 200,
					'step' => 5,
				],
				'em'  => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
				'rem' => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
			],
			'default'    => [
				'size' => 0,
				'unit' => 'rem',
			],
			'separator'  => 'before',
			'selectors'  => [
				'{{WRAPPER}} .sigma-portfolio-grid' => '--alsiha-column-gutter:{{SIZE}}{{UNIT}};',
			],
		];

		$fields['grids'] = [
			'type'        => 'repeater',
			'label'       => esc_html__( 'Add grids & Popup images.', 'alsiha' ),
			'mode'        => 'repeater',
			'title_field' => '{{{ text }}}',
			'separator'   => 'before',
			'fields'      => [
				'text'          => [
					'type'        => 'text',
					'label'       => esc_html__( 'Grid Text', 'alsiha' ),
					'default'     => esc_html__( 'Mango', 'alsiha' ),
					'label_block' => true,
				],
				'grid_image'    => [
					'type'      => 'media',
					'label'     => esc_html__( 'Upload Grid Image', 'alsiha' ),
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'separator' => 'before',
				],
				'image_gallery' => [
					'type'      => 'gallery',
					'label'     => esc_html__( 'Upload Popup Gallery', 'alsiha' ),
					'separator' => 'before',
				],
			],
		];

		$fields['grid_popup_gallery_section_end'] = $obj->endSection();

		return $fields;
	}

	/**
	 * Products section
	 *
	 * @param object $obj Reference object.
	 *
	 * @return array
	 */
	public static function productsControls( $obj ) {
		$fields['products_section'] = $obj->startSection(
			esc_html__( 'Products', 'alsiha' ),
		);

		$fields['product_gutter'] = [
			'type'       => 'slider',
			'label'      => esc_html__( 'Select Gutter Size.', 'alsiha' ),
			'mode'       => 'responsive',
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [
				'px'  => [
					'min'  => 0,
					'max'  => 200,
					'step' => 5,
				],
				'em'  => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
				'rem' => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
			],
			'default'    => [
				'size' => 0,
				'unit' => 'rem',
			],
			'selectors'  => [
				'{{WRAPPER}} .sigma-products-grid' => '--alsiha-column-gutter:{{SIZE}}{{UNIT}};',
			],
		];

		$fields['products'] = [
			'type'        => 'repeater',
			'label'       => esc_html__( 'Add Product images and links.', 'alsiha' ),
			'mode'        => 'repeater',
			'title_field' => '{{{ text }}}',
			'fields'      => [
				'text'       => [
					'type'    => 'text',
					'label'   => esc_html__( 'Product Name', 'alsiha' ),
					'default' => esc_html__( 'Mango', 'alsiha' ),
				],
				'grid_image' => [
					'type'    => 'media',
					'label'   => esc_html__( 'Upload Product Image', 'alsiha' ),
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				],
				'link'       => [
					'type'    => 'url',
					'label'   => esc_html__( 'Enter Product Link', 'alsiha' ),
					'options' => false,
					'default' => [
						'url' => '#',
					],
				],
			],
		];

		$fields['products_section_end'] = $obj->endSection();

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
			'type'       => 'slider',
			'label'      => esc_html__( 'Select Gutter Size.', 'alsiha' ),
			'mode'       => 'responsive',
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [
				'px'  => [
					'min'  => 0,
					'max'  => 200,
					'step' => 5,
				],
				'em'  => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
				'rem' => [
					'min'  => 0,
					'max'  => 20,
					'step' => 0.1,
				],
			],
			'default'    => [
				'size' => 15,
				'unit' => 'rem',
			],
			'selectors'  => [
				'{{WRAPPER}} .sigma-portfolio-grid' => '--alsiha-column-gutter:{{SIZE}}{{UNIT}};',
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
