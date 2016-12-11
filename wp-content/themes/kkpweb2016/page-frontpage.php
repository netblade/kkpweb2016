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
			get_template_part( 'content', 'page' );
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
                                if (!is_null($image) && array_key_exists('url', $image) ) {
                                    $image_content = '<img src="'.$image['url'].'" alt="" />' . "\n";
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
                                $carousel_content .= '<span class="carousel-caption-text">'.get_field('text', $p->ID).'</span>' . "\n";
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
                        $link_page = get_post($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_events']);
                        ?>
                        <a href="<?php echo $link_page->guid; ?>" class="box-header-title-link">Tapahtumat</a>
                    </div>
                    <div class="box-content">
                        <?php
                        // find date time now
                        $date_now = date('Y-m-d H:i:s');
                        // query events
                        $posts = get_posts(array(
                            'posts_per_page'	=> 5,
                            'post_type'			=> 'event',
                            'meta_query' 		=> array(
                                array(
                                    'key'			=> 'event_start',
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
                                <a href="<?php echo $p->guid; ?>">
                                    <?php echo $p->post_title; ?>
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <?php
                                $event_time_str = "";
                                $event_starts = new DateTime(get_field('event_start', $p->ID));
                                $event_ends = new DateTime(get_field('event_end', $p->ID));
                                if ($event_starts->format("ZY") == $event_ends->format("ZY")) {
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
                                        <a href="#" class="box-header-title-link"><?php echo $p->post_title; ?></a>
                                        <span class="box-header-title-right pull-right"><?php echo $event_time_str;?>.</span>
                                    </div>
                                    <div class="box-content">
                                        <div class="event_dialog_content">
                                            <?php echo $p->post_content; ?>
                                        </div>
                                        <dl>
                                            <dt>Lisätiedot</dt>
                                            <dd>dddMia Muhonen p. 040400423423</dd>
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
            </div>
            <div class="col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <?php
                        $link_page = get_post($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_news']);
                        ?>
                        <a href="<?php echo $link_page->guid; ?>" class="box-header-title-link">Ajankohtaista</a>
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
                                <a href="<?php echo $p->guid; ?>">
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
                <div class="box">
                    <div class="box-header">
                        <?php
                        $link_page = get_post($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_meetings']);
                        ?>
                        <a href="<?php echo $link_page->guid; ?>" class="box-header-title-link">Kokoukset</a>
                    </div>
                    <div class="box-content">
                        <?php
                        // find date time now
                            $date_now = date('Y-m-d H:i:s');
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
                                <a href="<?php echo $p->guid; ?>">
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
                                    $other_place = get_field('meeting_place_other', $p->ID);
                                    if ($other_place != "") {
                                        echo $other_place;
                                    } else {
                                        $field = get_field_object('meeting_place', $p->ID);
                                        $value = get_field("meeting_place", $p->ID);
                                        $label = $field['choices'][ $value ];
                                        echo $label;
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
                <div class="fb-like-box" data-href="https://www.facebook.com/kilonkipinat" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>
            </div>
        </div>
    </main>
</div>
<?php
 get_footer();
?>