<?php

$default_timezone = new DateTimeZone(get_option('timezone_string'));


$footer_last_edit_post = null;

$active_post_tree = array();

$kkpweb2016_template_options = get_option( 'kkpweb2016_settings_template' );
global $post;
$navigation_root_post = null;

function kkpweb2016_set_last_edit_post($last_edited_post) {
    global $footer_last_edit_post;

    $footer_last_edit_post = $last_edited_post;
}

function kkpweb2016_get_datestring($date_str, $forceShowYear = false) {
    global $default_timezone;
    $date = new DateTime($date_str, $default_timezone);

    $event_time_str = '<time class="dtstart" datetime="'.$date->format("Y-m-d H:iO").'">';

    if (date("Y") == $date->format("Y") && !$forceShowYear) {
        $event_time_str .= $date->format("d.m. H:i");
    } else {
        $event_time_str .= $date->format("d.m.Y H:i");
    }
    $event_time_str .= "</time>";

    return $event_time_str;
}

function kkpweb2016_get_datefromtostring($start_date_str, $end_date_str) {
    global $default_timezone;
    $start_date = new DateTime($start_date_str, $default_timezone);
    $end_date = new DateTime($end_date_str, $default_timezone);

    if ($start_date->format("zY") == $end_date->format("zY")) {
        if (date("Y") == $start_date->format("Y")) {
            $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
            $event_time_str .= $start_date->format("d.m.");
            $event_time_str .= '</time>';
        } else {
            $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
            $event_time_str .= $start_date->format("d.m.");
            $event_time_str .= '</time>';
        }
    } else {
        if ($start_date->format("Y") == $end_date->format("Y")) {
            if ($start_date->format("mY") == $end_date->format("mY")) {
                if (date("Y") == $start_date->format("Y")) {
                    $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $start_date->format("d.");
                    $event_time_str .= '</time>';
                    $event_time_str .= " - ";
                    $event_time_str = '<time class="dtends" datetime="'.$end_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $end_date->format("d.m.");
                    $event_time_str .= '</time>';
                } else {
                    $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $start_date->format("d.");
                    $event_time_str .= '</time>';
                    $event_time_str .= " - ";
                    $event_time_str = '<time class="dtends" datetime="'.$end_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $end_date->format("d.m.Y");
                    $event_time_str .= '</time>';
                }
            } else if ($start_date->format("Y") == $end_date->format("Y")) {

                if (date("Y") == $start_date->format("Y")) {
                    $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $start_date->format("d.m");
                    $event_time_str .= '</time>';
                    $event_time_str .= " - ";
                    $event_time_str = '<time class="dtends" datetime="'.$end_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $end_date->format("d.m.");
                    $event_time_str .= '</time>';
                } else {
                    $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $start_date->format("d.m");
                    $event_time_str .= '</time>';
                    $event_time_str .= " - ";
                    $event_time_str = '<time class="dtends" datetime="'.$end_date->format("Y-m-d H:iO").'">';
                    $event_time_str .= $end_date->format("d.m.Y");
                    $event_time_str .= '</time>';
                }
            } else {
                $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
                $event_time_str .= $start_date->format("d.m");
                $event_time_str .= '</time>';
                $event_time_str .= " - ";
                $event_time_str = '<time class="dtends" datetime="'.$end_date->format("Y-m-d H:iO").'">';
                $event_time_str .= $end_date->format("d.m.Y");
                $event_time_str .= '</time>';
            }
        } else {
            $event_time_str = '<time class="dtstart" datetime="'.$start_date->format("Y-m-d H:iO").'">';
            $event_time_str .= $start_date->format("d.m.Y");
            $event_time_str .= '</time>';
            $event_time_str .= " - ";
            $event_time_str = '<time class="dtends" datetime="'.$end_date->format("Y-m-d H:iO").'">';
            $event_time_str .= $end_date->format("d.m.Y");
            $event_time_str .= '</time>';

        }
    }
    return $event_time_str;
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

            $hide_user = get_field('hide_from_update_footer', 'user_'.$user->ID);
            if (!$hide_user) {
                $posts = get_posts(array(
                    'posts_per_page'	=> 1,
                    'post_type'			=> array('person', 'person_other'),
                    'meta_query' 		=> array(
                        array(
                            'key'			=> 'user',
                            'compare'		=> '=',
                            'value'         => $user->ID
                        )
                    )
                ));
                $person_post_id = 0;
                if( $posts ) {
                    foreach( $posts as $p ) {
                        $person_post_id = $p->ID;
                        break;
                    }
                }
                if ($person_post_id > 0) {
                    $to_ret .= ' (<a href="'.get_permalink($person_post_id).'">'.$user->display_name."</a>)";
                }
                else {
                    $to_ret .= " (".$user->display_name.")";
                }
            }
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



function kkpweb2016_get_template_part($post) {
    // Include the page content template.
    if (in_array($post->post_type, array('person', 'person_other'))) {
        get_template_part( 'content', 'persons');
    } elseif ($post->post_type == "event") {
        get_template_part( 'content', 'event');
    } elseif ($post->post_type == "meeting") {
        get_template_part( 'content', 'meeting');
    } else {
        get_template_part( 'content', 'page');
    }
}

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