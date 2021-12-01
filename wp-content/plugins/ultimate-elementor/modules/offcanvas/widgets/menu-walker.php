<?php
/**
 * UAEL Menu Walker
 *
 * @package UAEL
 */

namespace UltimateElementor\Modules\Offcanvas\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Menu_Walker.
 */
class Menu_Walker extends \Walker_Nav_Menu {

	/**
	 * Start element
	 *
	 * @since 1.27.2
	 * @param string $output Output HTML.
	 * @param object $item Individual Menu item.
	 * @param int    $depth Depth.
	 * @param array  $args Arguments array.
	 * @param int    $id Menu ID.
	 * @access public
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$args   = (object) $args;

		$class_names = '';
		$value       = '';
		$rel_xfn     = '';
		$rel_blank   = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$submenu = $args->has_children ? ' uael-offcanvas-menu-has-submenu' : '';

		if ( 0 === $depth ) {
			array_push( $classes, 'uael-offcanvas-menu-parent' );
		}

		$class_names = join( ' ', apply_filters( 'uael_offcanvas_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

		$class_names = ' class="' . esc_attr( $class_names ) . $submenu . ' uael-offcanvas-creative-menu"';
		$output     .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

		if ( isset( $item->target ) && '_blank' === $item->target && isset( $item->xfn ) && false === strpos( $item->xfn, 'noopener' ) ) {
			$rel_xfn = ' noopener';
		}
		if ( isset( $item->target ) && '_blank' === $item->target && isset( $item->xfn ) && empty( $item->xfn ) ) {
			$rel_blank = 'rel="noopener"';
		}
		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . $rel_xfn . '"' : '' . $rel_blank;
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		$item_output  = $args->has_children ? '<div class="uael-offcanvas-has-submenu-container">' : '';
		$item_output .= $args->before;
		$item_output .= '<a' . $attributes;
		if ( 0 === $depth ) {
			$item_output .= ' class = "uael-offcanvas-menu-item"';
		} else {
			$item_output .= in_array( 'current-menu-item', $item->classes, true ) ? ' class = "uael-offcanvas-sub-menu-item uael-offcanvas-sub-menu-item-active"' : ' class = "uael-offcanvas-sub-menu-item"';
		}
		$item_output .= '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if ( $args->has_children ) {
			$item_output .= "<span class='uael-offcanvas-menu-toggle uael-offcanvas-sub-arrow uael-offcanvas-menu-child-";
			$item_output .= $depth;
			$item_output .= "'><i class='fa'></i></span>";
		}
		$item_output .= '</a>';

		$item_output .= $args->after;
		$item_output .= $args->has_children ? '</div>' : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Display element
	 *
	 * @since 1.27.2
	 * @param object $element Individual Menu element.
	 * @param object $children_elements Child Elements.
	 * @param int    $max_depth Maximum Depth.
	 * @param int    $depth Depth.
	 * @param array  $args Arguments array.
	 * @param string $output Output HTML.
	 * @access public
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

		$id_field = $this->db_fields['id'];

		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
