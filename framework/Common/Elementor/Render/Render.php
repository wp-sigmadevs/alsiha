<?php
/**
 * Elementor Class: Render
 *
 * This class contains render logics & output.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Elementor\Render;

use Elementor\Utils;
use SigmaDevs\Sigma\Common\Traits\Singleton;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Elementor Class: Render
 *
 * @since 1.0.0
 */
class Render {
	/**
	 * Singleton Trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Element ID.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $id = null;

	/**
	 * HTML.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	private $html = null;

	/**
	 * Settings array
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public $getSettings;

	/**
	 * Carousel check.
	 *
	 * @var bool
	 * @since 1.0.0
	 */
	public $isCarousel = false;

	/**
	 * Unique name.
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $uniqueName = '';

	/**
	 * Element attributes.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	private $attributes = [];

	/**
	 * Container Wrapper HTML.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function container( $content ) {
		$this->id          = md5( (string) wp_rand() );
		$containerId       = 'sigma-container-' . $this->id;
		$containerClasses  = 'sigma-container ';
		$containerClasses .= $this->uniqueName;

		// Attributes for the container.
		$containerAttributes = [
			'id'    => $containerId,
			'class' => $containerClasses,
		];

		// Adding render attributes.
		$this->addAttribute( 'sigma_container_attr_' . $this->id, $containerAttributes );

		// Start rendering.
		$this->html = '<div ' . $this->getAttributeString( 'sigma_container_attr_' . $this->id ) . '>';

		// Content.
		$this->html = $this->row( $content );

		// End rendering.
		$this->html .= '</div><!-- .sigma-container -->';

		return $this->html;
	}

	/**
	 * Row Wrapper HTML.
	 *
	 * @param string $content The content.
	 *
	 * @return string
	 */
	public function row( $content ) {
		$row_classes = 'sigma-row sigma-content-loader element-loading';

		// Adding render attributes.
		$this->addAttribute( 'sigma_row_attr_' . $this->id, 'class', $row_classes );

		// Start rendering.
		$this->html .= '<div ' . $this->getAttributeString( 'sigma_row_attr_' . $this->id ) . '>';

		if ( $this->isCarousel ) {
			$slider_data = [
				'class' => 'sigma-carousel-slider swiper',
				'data'  => '',
			];

			// Adding slider render attributes.
			$this->addAttribute(
				'sigma_slider_attr_' . $this->id,
				[
					'class'        => 'sigma-col-grid ' . $slider_data['class'],
					'data-options' => $slider_data['data'],
				]
			);

			$this->html .= '<div ' . $this->getAttributeString( 'sigma_slider_attr_' . $this->id ) . '>';
		}

		$this->html .= $content;

		if ( $this->isCarousel ) {
			// Slider buttons.
			$this->html .= $this->renderSliderButtons();
			$this->html .= '</div><!-- .sigma-carousel-slider -->';
		}

		$this->html .= '</div><!-- .sigma-row -->';

		return $this->html;
	}

	/**
	 * Render Showcase Slider.
	 *
	 * @param array $settings Control settings.
	 *
	 * @return null|string
	 */
	public function showcaseSliderView( $settings, $uniqueName = '' ) {
		$this->getSettings = $settings;
		$this->isCarousel  = true;
		$this->uniqueName  = $uniqueName;

		// Container.
		$this->container( $this->renderSlider() );

		return $this->html;
	}

	private function renderSlider() {
		$html   = '';
		$slides = $this->getSettings['slides'] ?? [];

//		$html .= '<div class="preloader">';
//		$html .= '<div class="slider-preloader"></div>';
//		$html .= '</div>';
		$html .= '<div class="swiper-wrapper">';

		foreach ( $slides as $slide ) {
			ob_start();
			$image_src = $slide['image']['url'] ?? '';
			?>
				<div class="swiper-slide">
					<div class="slider-content">
						<div class="img-container">
							<div class="hero-banner" data-bg-image="<?php echo esc_url( $image_src ); ?>"></div>
						</div>
					</div>
				</div>
			<?php
			$html .= ob_get_clean();
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Renders slider buttons
	 *
	 * @return string
	 */
	public function renderSliderButtons() {
		ob_start();
		?>
		<div class="swiper-nav">
			<div class="swiper-arrow swiper-button-next">
				<svg width="24px" height="24px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M768 903.232l-50.432 56.768L256 512l461.568-448 50.432 56.768L364.928 512z" fill="currentColor" /></svg>
			</div>
			<div class="swiper-arrow swiper-button-prev">
				<svg width="24px" height="24px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M256 120.768L306.432 64 768 512l-461.568 448L256 903.232 659.072 512z" fill="currentColor" /></svg>
			</div>
		</div>

		<div class="swiper-pagination static-content"></div>
		<?php

		return ob_get_clean();
	}

	/**
	 * Add render attribute.
	 *
	 * @param array|string $element   The HTML element.
	 * @param array|string $key       Optional. Attribute key. Default is null.
	 * @param array|string $value     Optional. Attribute value. Default is null.
	 * @param bool         $overwrite Optional. Whether to overwrite existing.
	 *
	 * @return Render
	 */
	public function addAttribute( $element, $key = null, $value = null, $overwrite = false ) {
		if ( is_array( $element ) ) {
			foreach ( $element as $elementKey => $attributes ) {
				$this->addAttribute( $elementKey, $attributes, null, $overwrite );
			}

			return $this;
		}

		if ( is_array( $key ) ) {
			foreach ( $key as $attributeKey => $attributes ) {
				$this->addAttribute( $element, $attributeKey, $attributes, $overwrite );
			}

			return $this;
		}

		if ( empty( $this->attributes[ $element ][ $key ] ) ) {
			$this->attributes[ $element ][ $key ] = [];
		}

		settype( $value, 'array' );

		if ( $overwrite ) {
			$this->attributes[ $element ][ $key ] = $value;
		} else {
			$this->attributes[ $element ][ $key ] = array_merge( $this->attributes[ $element ][ $key ], $value );
		}

		return $this;
	}

	/**
	 * Get render attribute string.
	 *
	 * @param string $element The element.
	 *
	 * @return string
	 */
	public function getAttributeString( $element ) {
		if ( empty( $this->attributes[ $element ] ) ) {
			return '';
		}

		return Utils::render_html_attributes( $this->attributes[ $element ] );
	}
}
