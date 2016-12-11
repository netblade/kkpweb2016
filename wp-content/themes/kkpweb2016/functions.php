<?php

$footer_last_edit_post = null;

$active_post_tree = array();

$kkpweb2016_template_options = get_option( 'kkpweb2016_settings_template' );

function kkpweb2016_set_last_edit_post($last_edited_post) {
    global $footer_last_edit_post;

    $footer_last_edit_post = $last_edited_post;
}

function kkpweb2016_get_last_edit_string() {
    $to_ret = "";

    global $footer_last_edit_post;

    if ($footer_last_edit_post != null) {
        $date = new DateTime($footer_last_edit_post->post_modified_gmt);
        $date->format('Y-m-d H:i:s');
        $date->setTimeZone(new DateTimeZone('Europe/Helsinki'));

        $to_ret = "Viimeksi muokattu " . date_format($date, 'd.m.Y H:i:s');
        $user = get_userdata($footer_last_edit_post->post_author);
        if ($user != null) {
            $to_ret .= " (".$user->display_name.")";
        }

    }
    return $to_ret;
}

function kkpweb2016_list_child_pages() {
    $string = "";
    global $post;

    if ( is_page() && $post->post_parent ) {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
    }
    else {
        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
    }

    if ( $childpages ) {

        $string = '<ul>' . $childpages . '</ul>';
    }

    return $string;

}

function kkpweb2016_get_active_parent_tree_for_post($tmp_post, $counter = 0) {
    global $active_post_tree;

    if ($counter > 20) {
        return;
    }

    array_push($active_post_tree, $tmp_post->ID);

    if ($tmp_post->post_parent > 0 && $tmp_post->post_parent != $tmp_post->ID) {
        $parent_post = get_post($tmp_post->post_parent);
        kkpweb2016_get_active_parent_tree_for_post($parent_post, $counter++);
    }

}



function kkpweb2016_content_banner( $atts ) {
    $a = shortcode_atts( array(
        'type' => 'right',
        'content' => '',
    ), $atts );

    return '<div class="content_banner content_banner_'.$a['type'].'">'.$a['content'].'</div>';
}
add_shortcode( 'content_banner', 'kkpweb2016_content_banner' );

if (!class_exists("KKPWeb2016SettingsPage")) {
    require_once( get_template_directory() . '/functions_settings.php');
}

if (!function_exists("kkpweb2016_AddCustomPostTypes")) {
	require_once( get_template_directory() . '/kkpweb2016_customPostTypes.php');
}

if (!function_exists("kkpweb2016_AddCustomTaxonomies")) {
	require_once( get_template_directory() . '/kkpweb2016_customTaxonomies.php');
}

if (!function_exists("kkpweb2016_main_navi")) {
	require_once( get_template_directory() . '/functions_navigation.php');
}



?>