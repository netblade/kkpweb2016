<?php
function kkpweb2016_main_navi($current_post) {
    $string = "";
    global $post;
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
            $tmp_str .= '<a href="'.$page->guid.'">'.$title.'</a>';
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
                $tmp_str .= '<a href="'.$subpage->guid.'">'.$subpage_title.'</a>';
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
            $string .= '<a href="'.$page->guid.'">'.$title.'</a>';
            $string .= '</li>';
        }
    }
    $string .= '</ul>';
    return $string;
}
function kkpweb2016_side_navi_sub($current_post) {
    $string = "";
    global $active_post_tree;
    $args = array(
            'sort_column' => 'menu_order',
            'parent' => $current_post->ID
        );
    $subpages = get_pages($args);
    $has_sub_content = false;
    if (count($subpages) > 0) {
        $tmp_str = "";
        $tmp_str .= '<ul>';
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
            $tmp_str .= '<a href="'.$subpage->guid.'">'.$subpage_title.'</a>';
            if (in_array($subpage->ID, $active_post_tree)) {
                $tmp_str .= kkpweb2016_side_navi_sub($subpage);
            }
            $tmp_str .= '</li>';
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
    $string .= '<a href="'.$first_page_post->guid.'" class="box-header-title-link">'.$first_page_title.'</a>';
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
        if (in_array($page->ID, $active_post_tree)) {
            $string .= '<li class="active">';
        } else {
            $string .= '<li>';
        }
        $string .= '<a href="'.$page->guid.'">'.$title.'</a>';
        if (in_array($page->ID, $active_post_tree)) {
            $string .= kkpweb2016_side_navi_sub($page);
        }
        $string .= '</li>';
    }
    $string .= '</ul>';
    $string .= '</div>';
    $string .= '</div>';
    return $string;
}
