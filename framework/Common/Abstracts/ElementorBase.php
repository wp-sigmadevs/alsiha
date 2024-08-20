<?php
/**
 * Abstract Class: ElementorBase.
 *
 * The Base class can be implemented by classes for elementor addons development.
 *
 * @package SigmaDevs\Sigma
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace SigmaDevs\Sigma\Common\Abstracts;

use Exception;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use SigmaDevs\Sigma\Common\Utils\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Abstract Class: ElementorBase.
 *
 * @since 1.0.0
 */
abstract class ElementorBase extends Widget_Base {
	/**
	 * Widget Title.
	 *
	 * @var String
	 */
	public $title;

	/**
	 * Widget name.
	 *
	 * @var String
	 * @since 1.0.0
	 */
	public $name;

	/**
	 * Widget category.
	 *
	 * @var String
	 * @since 1.0.0
	 */
	public $themeCategory;

	/**
	 * Widget icon class
	 *
	 * @var String
	 * @since 1.0.0
	 */
	public $icon;

	/**
	 * Widget prefix.
	 *
	 * @var String
	 * @since 1.0.0
	 */
	public $prefix;

	/**
	 * Widget controls.
	 *
	 * @var array
	 * @since 1.0.0
	 */
	public $selectors = [];

	/**
	 * Class Constructor.
	 *
	 * @param array $data default data.
	 * @param array $args default arg.
	 *
	 * @throws Exception If arguments are missing when initializing a full widget
	 * instance.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function __construct( $data = [], $args = null ) {
		$this->actionsBeforeRender();

		parent::__construct( $data, $args );

		$this->themeCategory  = 'alsiha';
		$this->icon      = 'sigma-el-custom sigma-element';
		$this->prefix    = 'sigma_el_';
//		$this->selectors = ControlSelectors::getSelectors( $this );
	}

	/**
	 * Elementor widget controls.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	abstract public function widgetFields();

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set Widget Keyword.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function get_keywords() {
		return [ 'theme', 'sigma', 'alsiha' ];
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 */
	public function get_icon() {
		return $this->icon;
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 * @since  1.0.0
	 */
	public function get_categories() {
		return [ $this->themeCategory ];
	}

	/**
	 * Register widget controls.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function register_controls() {
		$fields = $this->widgetFields();

		if ( ! is_array( $fields ) ) {
			return;
		}

		$fields = apply_filters( 'sigmadevs/sigma/elementor/widget_controls/' . $this->name, $fields, $this );

		foreach ( $fields as $id => $field ) {
			$field['classes'] = ! empty( $field['classes'] ) ? $field['classes'] . ' elementor-control-sigma_el' : ' elementor-control-sigma_el';

			if ( ! empty( $field['type'] ) ) {
				$field['type'] = self::fields( $field['type'] );
			}

			if ( ! empty( $field['tab'] ) ) {
				$field['tab'] = self::tabs( $field['tab'] );
			}

			if ( isset( $field['mode'] ) && 'section_start' === $field['mode'] ) {
				unset( $field['mode'] );
				unset( $field['separator'] );

				$this->start_controls_section( $id, $field );
			} elseif ( isset( $field['mode'] ) && 'section_end' === $field['mode'] ) {
				$this->end_controls_section();
			} elseif ( isset( $field['mode'] ) && 'tabs_start' === $field['mode'] ) {
				unset( $field['mode'] );
				unset( $field['separator'] );

				$this->start_controls_tabs( $id );
			} elseif ( isset( $field['mode'] ) && 'tabs_end' === $field['mode'] ) {
				$this->end_controls_tabs();
			} elseif ( isset( $field['mode'] ) && 'tab_start' === $field['mode'] ) {
				unset( $field['mode'] );
				unset( $field['separator'] );

				$this->start_controls_tab( $id, $field );
			} elseif ( isset( $field['mode'] ) && 'tab_end' === $field['mode'] ) {
				$this->end_controls_tab();
			} elseif ( isset( $field['mode'] ) && 'group' === $field['mode'] ) {
				$type          = $field['type'];
				$field['name'] = $id;

				unset( $field['mode'] );
				unset( $field['type'] );

				$this->add_group_control( $type, $field );
			} elseif ( isset( $field['mode'] ) && 'responsive' === $field['mode'] ) {
				unset( $field['mode'] );

				$this->add_responsive_control( $id, $field );
			} elseif ( isset( $field['mode'] ) && 'popover_start' === $field['mode'] ) {
				unset( $field['mode'] );
				unset( $field['separator'] );

				$this->add_control( $id, $field );
				$this->start_popover();
			} elseif ( isset( $field['mode'] ) && 'popover_end' === $field['mode'] ) {
				$this->end_popover();
			} elseif ( isset( $field['mode'] ) && 'repeater' === $field['mode'] ) {
				$repeater       = new Repeater();
				$repeaterFields = $field['fields'];

				foreach ( $repeaterFields as $repeaterID => $value ) {
					if ( ! empty( $value['type'] ) ) {
						$value['type'] = self::fields( $value['type'] );
					}

					if ( isset( $value['mode'] ) && 'responsive' === $value['mode'] ) {
						unset( $value['mode'] );
						$repeater->add_responsive_control( $repeaterID, $value );
					} else {
						$repeater->add_control( $repeaterID, $value );
					}
				}

				$field['fields'] = $repeater->get_controls();

				$this->add_control( $id, $field );
			} else {
				$this->add_control( $id, $field );
			}
		}

		do_action( 'sigmadevs/sigma/after/register/controls' );
	}

	/**
	 * Elementor Edit mode.
	 *
	 * @return bool
	 * @since  1.0.0
	 */
	public function isEditMode() {
		return Plugin::$instance->preview->is_preview_mode() || Plugin::$instance->editor->is_edit_mode();
	}

	/**
	 * Elementor Edit mode script
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function editModeScript() {
		if ( ! $this->isEditMode() ) {
			return;
		}

		$ajaxUrl = admin_url( 'admin-ajax.php' );

		if ( in_array( 'sitepress-multilingual-cms/sitepress.php', get_option( 'active_plugins' ), true ) ) {
			$ajaxUrl = admin_url( 'admin-ajax.php?lang=' . ICL_LANGUAGE_CODE );
		}
		?>
		<script>
			var sl_sigma = {
				ajaxUrl: '<?php echo esc_url( $ajaxUrl ); ?>',
				nonce: '<?php echo esc_attr( wp_create_nonce( Helpers::nonceId() ) ); ?>',
			};
		</script>

		<?php
	}

	/**
	 * Starts an Elementor Section.
	 *
	 * @param string $label Section label.
	 * @param object $tab Tab ID.
	 * @param array  $conditions Section Condition.
	 * @param array  $condition Section Conditions.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function startSection( $label, $tab, $conditions = [], $condition = [] ) {
		$start = [
			'mode'  => 'section_start',
			'tab'   => $tab,
			'label' => $label,
		];

		if ( ! empty( $condition ) ) {
			$start['condition'] = $condition;
		}

		if ( ! empty( $conditions ) ) {
			$start['conditions'] = $conditions;
		}

		return $start;
	}

	/**
	 * Ends an Elementor Section.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function endSection() {
		return [
			'mode' => 'section_end',
		];
	}

	/**
	 * Starts an Elementor tab group.
	 *
	 * @param array $conditions Tab condition.
	 * @param array $condition Tab condition.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function startTabGroup( $conditions = [], $condition = [] ) {
		return [
			'mode'       => 'tabs_start',
			'conditions' => $conditions,
			'condition'  => $condition,
		];
	}

	/**
	 * Ends an Elementor tab group.
	 *
	 * @param array $conditions Tab condition.
	 * @param array $condition Tab condition.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function endTabGroup( $conditions = [], $condition = [] ) {
		return [
			'mode'       => 'tabs_end',
			'conditions' => $conditions,
			'condition'  => $condition,
		];
	}

	/**
	 * Starts an Elementor tab
	 *
	 * @param string $label Section label.
	 * @param array  $conditions Tab condition.
	 * @param array  $condition Tab condition.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function startTab( $label, $conditions = [], $condition = [] ) {
		return [
			'mode'       => 'tab_start',
			'label'      => $label,
			'conditions' => $conditions,
			'condition'  => $condition,
		];
	}

	/**
	 * Ends an Elementor tab.
	 *
	 * @param array $conditions Tab condition.
	 * @param array $condition Tab condition.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function endTab( $conditions = [], $condition = [] ) {
		return [
			'mode'       => 'tab_end',
			'conditions' => $conditions,
			'condition'  => $condition,
		];
	}

	/**
	 * Starts an Elementor Section Heading
	 *
	 * @param string $label Heading label.
	 * @param string $separator Section separator.
	 * @param array  $conditions Section Condition.
	 * @param array  $condition Section Conditions.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function renderHeading( $label, $separator = null, $conditions = [], $condition = [] ) {
		return [
			'type'            => 'html',
			'raw'             => sprintf(
				'<h3 class="sigma-elementor-group-heading">%s</h3>',
				$label
			),
			'separator'       => $separator,
			'content_classes' => 'elementor-panel-heading-title',
			'conditions'      => $conditions,
			'condition'       => $condition,
		];
	}

	/**
	 * Elementor Fields.
	 *
	 * @param string $type Control type.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private static function fields( $type ) {
		$controls = Controls_Manager::class;

		switch ( $type ) {
			case 'link':
				$type = $controls::URL;
				break;

			case 'image-dimensions':
				$type = $controls::IMAGE_DIMENSIONS;
				break;

			case 'html':
				$type = $controls::RAW_HTML;
				break;

			case 'switch':
				$type = $controls::SWITCHER;
				break;

			case 'popover':
				$type = $controls::POPOVER_TOGGLE;
				break;

			case 'typography':
				$type = Group_Control_Typography::get_type();
				break;

			case 'border':
				$type = Group_Control_Border::get_type();
				break;

			case 'background':
				$type = Group_Control_Background::get_type();
				break;

			case 'box-shadow':
				$type = Group_Control_Box_Shadow::get_type();
				break;

			case 'text-shadow':
				$type = Group_Control_Text_Shadow::get_type();
				break;

			case 'text-stroke':
				$type = Group_Control_Text_Stroke::get_type();
				break;

			default:
				$type = constant( 'Elementor\Controls_Manager::' . strtoupper( $type ) );

		}

		return $type;
	}

	/**
	 * Elementor Fields.
	 *
	 * @param string $tab Tab.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	private static function tabs( $tab ) {
		return constant( 'Elementor\Controls_Manager::TAB_' . strtoupper( $tab ) );
	}

	/**
	 * Start rendering.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function renderStart() {
		if ( ! $this->isEditMode() ) {
			return;
		}

		//add_filter( 'wp_kses_allowed_html', [ FilterHooks::class, 'custom_wpkses_post_tags' ], 10, 2 );
	}

	/**
	 * End rendering.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function renderEnd() {
		$this->editModeScript();
	}

	/**
	 * Actions before rendering.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	protected function actionsBeforeRender() {
		if ( ! $this->isEditMode() ) {
			return;
		}

		add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
	}
}
