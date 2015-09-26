<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package limitless-career
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ashley_limitless_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'ashley_limitless_body_classes' );

function ashley_limitless_bloginfo_color( $bloginfo ) {
	$bloginfo = "Land Your DREAM Job in 8 Weeks or Less";
	$bloginfo = preg_replace('#\b([A-Z]+)\b#', '<span class="ashley">${1}</span>', $bloginfo);

	return $bloginfo;
}

add_filter( 'bloginfo_colors', 'ashley_limitless_bloginfo_color' );
