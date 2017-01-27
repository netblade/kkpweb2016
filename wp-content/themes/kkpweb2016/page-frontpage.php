<?php
/*
Template Name: Etusivu
*/
get_header();

global $kkpweb2016_template_options;

?>
<div class="content" id="content">
    <main id="main" class="site-main" role="main">
        <div class="row">
            <div class="col-lg-6">
                <?php
		// Start the loop.
		while ( have_posts() ) {
            the_post();
			// Include the page content template.
			kkpweb2016_get_template_part($post);
        }
                ?>
            </div>
            <div class="col-lg-6">

                <?php
                $carousel_li_content = "";
                $carousel_content = "";

                        // query carousel
                        $posts = get_posts(array(
                            'posts_per_page'	=> 5,
                            'post_type'			=> 'carousel',
                            'order'				=> 'ASC',
                            'orderby'			=> 'menu_order',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'carousel_area',
                                    'field' => 'slug',
                                    'terms' => "etusivu",
                                    'include_children' => false
                                )
                            )
                        ));
                        if( $posts ) {
                            $counter = 0;
                            foreach( $posts as $p ) {

                                $image = get_field('image', $p->ID);
                                $link = get_field('link', $p->ID);
                                $link_str = "";
                                $link_end_str = "";
                                if ($link != "") {
                                    $link_str='<a href="' . get_permalink($link) . '">';
                                    $link_end_str = '</a>';
                                }

                                if (!is_null($image) && array_key_exists('url', $image) ) {
                                    $image_content = $link_str.'<img src="'.$image['url'].'" alt="" />' . $link_end_str . "\n";
                                } else {
                                    continue;
                                }

                                if ($counter == 0) {
                                    $carousel_li_content .= '<li data-target="#carousel-frontpage" data-slide-to="'.$counter.'" class="active"></li>';
                                    $carousel_content .= '<div class="item active">' . "\n";
                                } else {
                                    $carousel_li_content .= '<li data-target="#carousel-frontpage" data-slide-to="'.$counter.'" class=""></li>';
                                    $carousel_content .= '<div class="item">' . "\n";
                                }



                                $carousel_content .= $image_content;
                                $carousel_content .= '<div class="carousel-caption">' . "\n";
                                $carousel_content .= '<span class="carousel-caption-text">' .  get_field('text', $p->ID).'</span>' . "\n";
                                $carousel_content .= '</div>' . "\n";
                                $carousel_content .= '</div>' . "\n";

                                $counter++;
                            }
                        }
                ?>

                <div id="carousel-frontpage" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php echo $carousel_li_content; ?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php echo $carousel_content; ?>
                    </div>
                    <a class="left carousel-control" href="#carousel-frontpage" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-frontpage" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <?php

                        $link_page = get_permalink($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_events']);
                        
                        ?>
                        <a href="<?php echo $link_page; ?>" class="box-header-title-link">Tapahtumat</a>
                    </div>
                    <div class="box-content">
                        <?php
                        // find date time now
                        $date_now = date('Y-m-d') . ' 00:00:00';
                        // query events
                        $posts = get_posts(array(
                            'posts_per_page'	=> 5,
                            'post_type'			=> 'event',
                            'meta_query' 		=> array(
                                array(
                                    'key'			=> 'event_end',
                                    'compare'		=> '>',
                                    'value'         => $date_now,
                                    'type'			=> 'DATETIME'
                                )
                            ),
                            'order'				=> 'ASC',
                            'orderby'			=> 'meta_value',
                            'meta_key'			=> 'event_start',
                            'meta_type'			=> 'DATETIME'
                        ));
                        if( $posts ) {
                            foreach( $posts as $p ) {
                        ?>

                        <div class="row event_header">
                            <div class="col-lg-6">
                                <a href="<?php echo get_permalink($p->ID); ?>">
                                    <?php echo $p->post_title; ?>
                                </a>
                            </div>
                            <div class="col-lg-3 text-nowrap">
                                <?php
                                $event_time_str = "";
                                $event_starts = new DateTime(get_field('event_start', $p->ID));
                                $event_ends = new DateTime(get_field('event_end', $p->ID));
                                if ($event_starts->format("zY") == $event_ends->format("zY")) {
                                    if (date("Y") == $event_starts->format("Y")) {
                                        $event_time_str = $event_starts->format("d.m. H:i");
                                    } else {
                                        $event_time_str = $event_starts->format("d.m.Y H:i");
                                    }
                                } else {
                                    if ($event_starts->format("Y") == $event_ends->format("Y")) {
                                        if (date("mY") == $event_starts->format("mY")) {
                                            $event_time_str = $event_starts->format("d.") . " - " . $event_ends->format("d.m.");
                                        } else if (date("Y") == $event_starts->format("Y")) {
                                            $event_time_str = $event_starts->format("d.m.") . " - " . $event_ends->format("d.m.");
                                        } else {
                                            $event_time_str = $event_starts->format("d.m.") . " - " . $event_ends->format("d.m.Y");
                                        }
                                    } else {
                                        $event_time_str = $event_starts->format("d.m.Y") . " - " . $event_ends->format("d.m.Y");

                                    }
                                }
                                echo $event_time_str;


                                ?>
                            </div>
                            <div class="col-lg-3 text-right"><?php
                                $event_place_str = "";

                                $other_place = get_field('place_other', $p->ID);
                                if ($other_place != "") {
                                    $event_place_str = $other_place;
                                } else {
                                    $value = get_field("place", $p->ID);
                                    $label = $value['label'];
                                    $event_place_str = $label;
                                }
                                echo $event_place_str;
?></div>
                            <div class="event_dialog">
                                <div class="box">
                                    <div class="box-header">
                                        <a href="<?php echo get_permalink($p->ID); ?>" class="box-header-title-link">
                                            <?php echo $p->post_title; ?>
                                        </a>
                                    </div>
                                    <div class="box-content">
                                        <span class="box-header-title-right pull-right">
                                            <?php echo $event_time_str;?>
                                        </span>
                                        <div class="event_dialog_content">
                                            <?php echo $p->post_content; ?>
                                        </div>
                                        <dl>
                                            <?php
                                                $additional_details = "";

                                                $email = "";
                                                $email_str = "";

                                                $person = get_field('info_person_kipinat', $p->ID);

                                                if (trim($person) == "")
                                                {
                                                    $person = get_field('info_person_other', $p->ID);
                                                }
                                                if (trim($person) != "")
                                                {
                                                    $person_post = get_post($person);
                                                    if ($person_post != null) {
                                                        $additional_details = $person_post->post_title;
                                                        $phone = get_field('mobile', $person);
                                                        if ($phone != null && trim($phone) != "") {
                                                            $phone_trim = str_replace(" ", "", str_replace("-", "", trim($phone)));
                                                            if ($phone_trim != "") {
                                                                $phone_str = '<script type="text/javascript">document.write("'.str_rot13('<a class=\"more_info_phone\" href=\"tel:'.$phone_trim.'\" rel=\"nofollow\">'.$phone.'</a>').'".replace(/[a-zA-Z]/g,function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));</script>';
                                                                $additional_details .= " p. ". $phone_str;
                                                            }
                                                        }
                                                        $user = get_field('user', $person);
                                                        if ($user != null) {
                                                            $userdata = get_userdata( $user['ID'] );
                                                            $email = $userdata->user_email;
                                                        }
                                                    }
                                                }

                                                if (trim($email) != "") {
                                                    $email_str = '<script type="text/javascript">document.write("'.str_rot13('<a class=\"more_info_email\" href=\"mailto:'.$email.'\" rel=\"nofollow\">'.$email.'</a>').'".replace(/[a-zA-Z]/g,function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));</script>';
                                                    $additional_details .= ' @: ' . $email_str;
                                                }

                                                if (trim($additional_details) == "") {
                                                    $additional_details = get_field('info_manual_text', $p->ID);
                                                }

                                                if (trim($additional_details) != "") {
                                            ?>
                                            <dt>Lisätiedot</dt>
                                            <dd>
                                                <?php echo $additional_details; ?>
                                            </dd>
                                            <?php
                                                }

                                            ?>
                                            <dt>Paikka</dt>
                                            <dd><?php echo $event_place_str;?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <br />
                <div class="box">
                    <div class="box-header">
                        <?php
                        $link_page = get_permalink($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_meetings']);
                        ?>
                        <a href="<?php echo $link_page; ?>" class="box-header-title-link">Kokoukset</a>
                    </div>
                    <div class="box-content">
                        <?php
                        // find date time now
                        $date_now = date('Y-m-d') . ' 00:00:00';
                        // query events
                        $posts = get_posts(array(
	                        'posts_per_page'	=> 5,
	                        'post_type'			=> 'meeting',
	                        'meta_query' 		=> array(
		                        array(
	                                'key'			=> 'meeting_starts',
	                                'compare'		=> '>',
                                    'value'         => $date_now,
	                                'type'			=> 'DATETIME'
	                            )
                            ),
	                        'order'				=> 'ASC',
	                        'orderby'			=> 'meta_value',
	                        'meta_key'			=> 'meeting_starts',
	                        'meta_type'			=> 'DATETIME'
                        ));
                        if( $posts ) {
                            foreach( $posts as $p ) {
                        ?>

                        <div class="row">
                            <div class="col-lg-6">
                                <a href="<?php echo get_permalink($p->ID); ?>">
                                    <?php echo $p->post_title; ?>
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <?php
                                $meeting_starts = new DateTime(get_field('meeting_starts', $p->ID));
                                if (date("Y") == $meeting_starts->format("Y")) {
                                    echo $meeting_starts->format("d.m. H:i");
                                } else {
                                    echo $meeting_starts->format("d.m.Y H:i");
                                }
                                ?>
                            </div>
                            <div class="col-lg-3 text-right">
                                <?php
                                $other_place = get_field('place_other', $p->ID);
                                if ($other_place != "") {
                                    echo $other_place;
                                } else {
                                    $value = get_field("place", $p->ID);
                                    if (is_array($value) && array_key_exists('label', $value)) {
                                        $label = $value['label'];
                                        echo $label;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <?php
                        $link_page = get_permalink($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_news']);
                        ?>
                        <a href="<?php echo $link_page; ?>" class="box-header-title-link">Ajankohtaista</a>
                    </div>
                    <div class="box-content">

                        <?php

                        $posts = get_posts(array(
                            'posts_per_page'	=> 5,
                            'post_type'			=> 'news',
                            'order'				=> 'DESC',
                            'orderby'			=> 'date'
                        ));
                        if( $posts ) {
                                foreach( $posts as $p ) {
                        ?>

                        <div class="row event_header">
                            <div class="col-lg-8">
                                <a href="<?php echo get_permalink($p->ID); ?>">
                                    <?php echo $p->post_title; ?>
                                </a>
                            </div>
                            <div class="col-lg-4 text-right"><?php
                                    $published = new DateTime($p->post_date);

                                    echo $published->format("d.m.Y H:i")
                            ?></div>
                        </div>


                                <?php

                                }

                        }

                                ?>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-lg-6">
                <?php echo do_shortcode('[instagram-feed id="3055900978" showheader="false"]'); ?>
            </div>
            <div class="col-lg-6">
                <div class="fb-page" data-href="https://www.facebook.com/kilonkipinat" data-tabs="timeline" data-width="540" data-height="740" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/kilonkipinat" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/kilonkipinat">Kilon Kipinät</a>
                    </blockquote>
                </div>
            </div>
        </div>
        <br />
    </main>
</div>
<?php
 get_footer();
?>