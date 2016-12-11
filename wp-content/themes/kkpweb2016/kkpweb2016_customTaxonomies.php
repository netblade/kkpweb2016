<?php
add_action( 'init', 'kkpweb2016_AddCustomTaxonomies' );

function kkpweb2016_AddCustomTaxonomies() {
    register_taxonomy('carousel_area', array('carousel'), array(
		'hierarchical' => false,
		'labels' => array(
			'name' => _x( 'Karusellin alue', 'taxonomy general name' ),
			'singular_name' => _x( 'Karusellin alue', 'taxonomy singular name' ),
			'menu_name' => __( 'Karusellin alueet' )
		),
		'rewrite' => array(
			'slug' => 'carousel_area',
			'with_front' => false,
			'hierarchical' => false
		)
	));
}
