<?php
/**
 * Elementor Addon for Lazy Load Control
 *
 * @package       EALLC
 * @author        Technocrackers
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Elementor Addon for Lazy Load Control
 * Plugin URI:    https://technocrackers.com/
 * Description:   Remove the Lazy Load attribute from specific images in Elementor.
 * Version:       1.0.0
 * Author:        Technocrackers
 * Author URI:    https://technocrackers.com/
 * Text Domain:   elementor-addon-for-lazy-load-control
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with Elementor Addon for Lazy Load Control. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'elementor/element/image/section_image/before_section_end', function( $element, $args ) {
	$element->start_injection( [
		'at' => 'after',
		'of' => 'link',
	] );
	$element->add_control(
		'eallc_image_lazy_loading',
		[
			'label' => __( 'Lazy Loading','elementor-addon-for-lazy-load-control' ),
			'type' => \Elementor\Controls_Manager::SELECT,
      'default' => 'lazy',
			'options' => [
				'lazy' => __( 'Lazy load','elementor-addon-for-lazy-load-control' ),
				'no_lazy' => __( 'Do not lazy load','elementor-addon-for-lazy-load-control' ),
			],
		]
	);
	$element->end_injection();
}, 10, 2 );

add_action( 'elementor/widget/render_content', function( $content, $widget ){
  if( $widget->get_name() === 'image' ){
    $settings = $widget->get_settings();
	$content = str_replace( ' loading="lazy"','',$content );
	if( ! isset( $settings['eallc_image_lazy_loading'] ) || 'lazy' === sanitize_text_field( $settings['eallc_image_lazy_loading'] ) ) {
		$content = str_replace(
			array(
				'<img'
			),
			array(
				'<img loading="lazy"'
			), $content );
	}
  }
  return $content;
}, 10, 2 );
