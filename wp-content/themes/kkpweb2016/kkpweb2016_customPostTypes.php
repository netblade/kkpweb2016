<?php
/**
 * kkpweb2016 custom post types
 */

add_action( 'init', 'kkpweb2016_AddCustomPostTypes' );

function kkpweb2016_AddCustomPostTypes() {

    register_post_type( 'news',
		array(
			'labels' => array(
				'name' => __( 'Uutiset' ),
				'singular_name' => __( 'Uutinen' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-admin-site',
            'supports' => array('title', 'editor', 'thumbnail')
		)
	);

    register_post_type( 'meeting',
		array(
			'labels' => array(
				'name' => __( 'Kokoukset' ),
				'singular_name' => __( 'Kokous' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-format-status'
		)
	);

    register_post_type( 'event',
		array(
			'labels' => array(
				'name' => __( 'Tapahtumat' ),
				'singular_name' => __( 'Tapahtuma' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-calendar'
		)
	);

    register_post_type( 'person',
		array(
			'labels' => array(
				'name' => __( 'Kipin&auml;t' ),
				'singular_name' => __( 'Kipin&auml;' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-admin-users',
            'supports' => array('title', 'editor', 'thumbnail','page-attributes')
		)
	);
/*
    register_post_type( 'group',
		array(
			'labels' => array(
				'name' => __( 'Toimintaryhm&auml;t' ),
				'singular_name' => __( 'Toimintaryhm&auml;' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-groups',
            'hierarchical' => true,
            'supports' => array('title', 'editor', 'thumbnail','page-attributes')
		)
	);*/

    register_post_type( 'carousel',
		array(
			'labels' => array(
				'name' => __( 'Karuselli' ),
				'singular_name' => __( 'Karuselli' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-images-alt',
            'hierarchical' => true,
            'supports' => array('title','page-attributes')
		)
	);

    register_post_type( 'person_other',
		array(
			'labels' => array(
				'name' => __( 'Muut henkil&ouml;t' ),
				'singular_name' => __( 'Muu henkil&ouml;' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-admin-users',
            'supports' => array('title', 'editor', 'thumbnail','page-attributes')
		)
	);

}