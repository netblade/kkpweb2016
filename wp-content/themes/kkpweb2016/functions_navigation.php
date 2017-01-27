<?php
function kkpweb2016_main_navi($current_post) {
    $string = "";
//    global $post;
    kkpweb2016_get_active_parent_tree_for_post($current_post, 0);
    global $active_post_tree;
    $frontpage = get_option('page_on_front');
    $args = array(
        'sort_column' => 'menu_order',
        'parent' => 0
    );
    $pages = get_pages($args);
    $string = '<ul class="nav navbar-nav">';
    foreach($pages as $page)
    {
        if ($page->ID == $frontpage) {
            continue;
        }
        if (get_post_meta($page->ID, "kkpweb2016_hide_from_navigation", true)) {
            continue;
        }
        $title = $page->post_title;
        $additional_title = get_post_meta($page->ID, "kkpweb2016_navigation_title", true);
        if ($additional_title != "" && strlen($additional_title) > 2) {
            $title = $additional_title;
        }
        $args = array(
            'sort_column' => 'menu_order',
            'parent' => $page->ID
        );
        $subpages = get_pages($args);
        $has_sub_content = false;
        if (count($subpages) > 0) {
            $tmp_str = "";
            if (in_array($page->ID, $active_post_tree)) {
                $tmp_str .= '<li class="dropdown active">';
            } else {
                $tmp_str .= '<li class="drowdown">';
            }
            $tmp_str .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$page->post_title.'&nbsp;<span class="caret"></span></a>';
            $tmp_str .= '<ul class="dropdown-menu">';
            $tmp_str .= '<li class="main_page">';
            $tmp_str .= '<a href="'.get_permalink($page->ID).'">'.$title.'</a>';
            $tmp_str .= '</li>';
            $tmp_str .= '<li role="separator" class="divider"></li>';
            foreach($subpages as $subpage)
            {
                if (get_post_meta($subpage->ID, "kkpweb2016_hide_from_navigation", true)) {
                    continue;
                }
                $subpage_title = $subpage->post_title;
                $additional_title = get_post_meta($subpage->ID, "kkpweb2016_navigation_title", true);
                if ($additional_title != "" && strlen($additional_title) > 2) {
                    $subpage_title = $additional_title;
                }
                if (in_array($subpage->ID, $active_post_tree)) {
                    $tmp_str .= '<li class="active">';
                } else {
                    $tmp_str .= '<li>';
                }
                $tmp_str .= '<a href="'.get_permalink($subpage->ID).'">'.$subpage_title.'</a>';
                $tmp_str .= '</li>';
                $has_sub_content = true;
            }
            $tmp_str .= '</ul>';
            $tmp_str .= '</li>';
            if ($has_sub_content) {
                $string .= $tmp_str;
            }
        }
        if (!$has_sub_content) {
            if (in_array($page->ID, $active_post_tree)) {
                $string .= '<li class="active">';
            } else {
                $string .= '<li>';
            }
            $string .= '<a href="'.get_permalink($page->ID).'">'.$title.'</a>';
            $string .= '</li>';
        }
    }
    $string .= '</ul>';
    return $string;
}
function kkpweb2016_side_navi_sub($current_post, $active_post_id = null) {
    $string = "";
    global $active_post_tree;
    $args = array(
            'sort_column' => 'menu_order',
            'parent' => $current_post->ID
        );
    $subpages = get_pages($args);

    $custom_content = "";

    $has_sub_content = false;

    if ($current_post->ID == $active_post_id)
    {
        $custom_content = kkpweb2016_side_navi_custom_contents_wrapper($current_post);
    }

    if (count($subpages) > 0 || !empty(trim($custom_content)))
    {
        $tmp_str = "";
        $tmp_str .= '<ul>';

        if (count($subpages) > 0) {
            foreach($subpages as $subpage)
            {
                if (get_post_meta($subpage->ID, "kkpweb2016_hide_from_navigation", true)) {
                    continue;
                }
                $subpage_title = $subpage->post_title;
                $additional_title = get_post_meta($subpage->ID, "kkpweb2016_navigation_title", true);
                if ($additional_title != "" && strlen($additional_title) > 2) {
                    $subpage_title = $additional_title;
                }
                if ($subpage->ID == $active_post_id) {
                    $tmp_str .= '<li class="active">';
                    $a_class = 'active';
                }
                elseif (in_array($subpage->ID, $active_post_tree)) {
                    $tmp_str .= '<li class="active_tree">';
                    $a_class = 'active_tree';
                } else {
                    $tmp_str .= '<li>';
                    $a_class = "";
                }
                $tmp_str .= '<a class="'.$a_class.'" href="'.get_permalink($subpage->ID).'">'.$subpage_title.'</a>';
                if (in_array($subpage->ID, $active_post_tree)) {
                    $tmp_str .= kkpweb2016_side_navi_sub($subpage, $active_post_id);
                }
                $tmp_str .= '</li>';
                $has_sub_content = true;
            }
        }

        if (!empty(trim($custom_content)))
        {
            $tmp_str .= $custom_content;
            $has_sub_content = true;
        }

        $tmp_str .= '</ul>';
        if ($has_sub_content) {
            $string .= $tmp_str;
        }
    }

    return $string;
}
function kkpweb2016_side_navi($current_post) {
    global $active_post_tree;
    $first_page = end($active_post_tree);
    $first_page_post = get_post($first_page);
    $first_page_post_additional_title = get_post_meta($first_page, "kkpweb2016_navigation_title", true);
    $first_page_title = $first_page_post->post_title;
    if ($first_page_post_additional_title != "" && strlen($first_page_post_additional_title) > 2) {
        $first_page_title = $first_page_post_additional_title;
    }
    $args = array(
        'sort_column' => 'menu_order',
        'parent' => $first_page
    );
    $pages = get_pages($args);
    $string = '<div class="box">';
	$string .= '<div class="box-header">';
    $string .= '<a href="'.get_permalink($first_page_post->ID).'" class="box-header-title-link">'.$first_page_title.'</a>';
	$string .= '</div>';
	$string .= '<div id="left_navi_container" class="box-content">';
    $string .= '<ul>';
    foreach($pages as $page)
    {
        if (get_post_meta($page->ID, "kkpweb2016_hide_from_navigation", true)) {
            continue;
        }
        $title = $page->post_title;
        $additional_title = get_post_meta($page->ID, "kkpweb2016_navigation_title", true);
        if ($additional_title != "" && strlen($additional_title) > 2) {
            $title = $additional_title;
        }
        if ($page->ID == $current_post->ID) {
            $string .= '<li class="active">';
            $a_class = 'active';
        }
        elseif (in_array($page->ID, $active_post_tree)) {
            $string .= '<li class="active_tree">';
            $a_class = 'active_tree';
        } else {
            $string .= '<li>';
            $a_class = '';
        }
        $string .= '<a class="'.$a_class.'" href="'.get_permalink($page->ID).'">'.$title.'</a>';
        if (in_array($page->ID, $active_post_tree)) {
            $string .= kkpweb2016_side_navi_sub($page, $current_post->ID);

        }
        $string .= '</li>';
    }
    if ($current_post->ID == $first_page_post->ID)
    {
        $string .= kkpweb2016_side_navi_custom_contents_wrapper($current_post);
    }
    $string .= '</ul>';
    $string .= '</div>';
    $string .= '</div>';
    return $string;
}

function kkpweb2016_side_navi_custom_contents_wrapper($custom_page) {

    $retStr = "";

    $page_template = get_post_meta($custom_page->ID, "_wp_page_template", true);
    if ($page_template != "") {
        switch ($page_template) {
            case "page-tapahtumat.php":
                $retStr = kkpweb2016_side_navi_tapahtumat(get_permalink($custom_page->ID));
                break;
        }
    }

    return $retStr;
}

function kkpweb2016_side_navi_tapahtumat($permalink) {
    $retStr = "";
    $start_year = 2017;
    $end_year = (int) date('Y');

    $start_year_query = get_posts(array(
        'posts_per_page'	=> 1,
        'post_type'			=> 'event',
        'meta_query' 		=> array(
            array(
                'key'			=> 'event_start',
                'compare'		=> '>',
                'value'         => '2001-01-01',
                'type'			=> 'DATETIME'
            )
        ),
        'order'				=> 'ASC',
        'orderby'			=> 'meta_value',
        'meta_key'			=> 'event_start',
        'meta_type'			=> 'DATETIME'
    ));



    if( $start_year_query ) {
        foreach( $start_year_query as $p ) {
            $event_starts = new DateTime(get_field('event_start', $p->ID));
            $start_year = (int) $event_starts->format("Y");
        }
    }

    $end_year_query = get_posts(array(
        'posts_per_page'	=> 1,
        'post_type'			=> 'event',
        'meta_query' 		=> array(
            array(
                'key'			=> 'event_start',
                'compare'		=> '<',
                'value'         => '2030-01-01',
                'type'			=> 'DATETIME'
            )
        ),
        'order'				=> 'DESC',
        'orderby'			=> 'meta_value',
        'meta_key'			=> 'event_start',
        'meta_type'			=> 'DATETIME'
    ));



    if( $end_year_query ) {
        foreach( $end_year_query as $p ) {
            $event_ends = new DateTime(get_field('event_start', $p->ID));
            $end_year = (int) $event_ends->format("Y");
        }
    }

    for ($i = $start_year; $i <= $end_year; $i++) {
        $retStr .= '<li><a href="'.$permalink.'?events_year='.$i.'">'.$i.'</a></li>';
    }



    return $retStr;
}
