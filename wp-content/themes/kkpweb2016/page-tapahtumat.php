<?php
/*
Template Name: Tapahtumat
 */
get_header();

global $kkpweb2016_template_options;
global $navigation_root_post;



if (array_key_exists("events_year", $_GET) && $_GET["events_year"] != "" && is_numeric($_GET["events_year"])) {

    $year = (int) $_GET["events_year"];

    $start_date = date('Y-m-d H:i:s', strtotime($year . '-01-01'));

    $end_date = date('Y-m-d H:i:s', (strtotime(($year + 1) . '-01-01') - 1));

    $meta_query_events = array(
        array(
            'key'			=> 'event_start',
            'compare'		=> '>=',
            'value'         => $start_date,
            'type'			=> 'DATETIME'
        ),
        array(
            'key'			=> 'event_start',
            'compare'		=> '<=',
            'value'         => $end_date,
            'type'			=> 'DATETIME'
        )
    );

    $meta_query_meetings = array(
        array(
            'key'			=> 'meeting_starts',
            'compare'		=> '>=',
            'value'         => $start_date,
            'type'			=> 'DATETIME'
        ),
        array(
            'key'			=> 'meeting_starts',
            'compare'		=> '<=',
            'value'         => $end_date,
            'type'			=> 'DATETIME'
        )
    );

} else {

    // find date time now
    $date_now = date('Y-m-d') . ' 00:00:00';
    $meta_query_events = array(
        array(
            'key'			=> 'event_start',
            'compare'		=> '>=',
            'value'         => $date_now,
            'type'			=> 'DATETIME'
        )
    );

    $meta_query_meetings = array(
        array(
            'key'			=> 'meeting_starts',
            'compare'		=> '>=',
            'value'         => $date_now,
            'type'			=> 'DATETIME'
        )
    );
}


?>
<div class="content" id="content">

    <main id="main" class="site-main" role="main">
        <div class="row">
            <div class="col-lg-2">
                <?php
                echo kkpweb2016_side_navi($navigation_root_post);
                ?>
            </div>
            <div class="col-lg-10">
                <?php
                // Start the loop.
                while ( have_posts() ) {
                    the_post();
                    // Include the page content template.
                    kkpweb2016_get_template_part($post);
                }
                ?>
                <br />

                <div class="row">
                    <div class="col-lg-6">
                        <h2>Tapahtumat</h2>
                        <?php

                        // query events
                        $posts = get_posts(array(
                            'posts_per_page'	=> -1,
                            'post_type'			=> 'event',
                            'meta_query' 		=> $meta_query_events,
                            'order'				=> 'ASC',
                            'orderby'			=> 'meta_value',
                            'meta_key'			=> 'event_start',
                            'meta_type'			=> 'DATETIME'
                        ));
                        if( $posts ) {
                            foreach( $posts as $p ) {
                        ?>

                        <div class="row event_row">
                            <div class="col-lg-6">
                                <a href="<?php echo get_permalink($p->ID); ?>"><?php echo $p->post_title; ?></a>
                                <br />
                                <?php
                                $event_place_str = "";

                                $other_place = get_field('place_other', $p->ID);
                                if ($other_place != "") {
                                    $event_place_str = $other_place;
                                } else {
                                    $value = get_field("place", $p->ID);
                                    if (is_array($value)) {
                                        $label = $value['label'];
                                        $event_place_str = $label;
                                    }
                                }
                                echo $event_place_str;
                                ?>
                            </div>
                            <div class="col-lg-6 text-nowrap text-right">
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
                        </div>
                        <?php
                    }
                } else {
                        ?>
                        <p>Ei tapahtumia</p>
                        <?php
                        }
                        
                        ?>
                    </div>
                    <div class="col-lg-6">
                        <h2>Kokoukset</h2>
                        <?php
                        // find date time now
                        $date_now = date('Y-m-d H:i:s');
                        // query events
                        $posts = get_posts(array(
	                        'posts_per_page'	=> -1,
	                        'post_type'			=> 'meeting',
	                        'meta_query' 		=> $meta_query_meetings,
	                        'order'				=> 'ASC',
	                        'orderby'			=> 'meta_value',
	                        'meta_key'			=> 'meeting_starts',
	                        'meta_type'			=> 'DATETIME'
                        ));
                        if( $posts ) {
                            foreach( $posts as $p ) {
                        ?>

                        <div class="row event_row">
                            <div class="col-lg-6">
                                <a href="<?php echo get_permalink($p->ID); ?>"><?php echo $p->post_title; ?></a>
                                <br />
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
                            <div class="col-lg-6 text-nowrap text-right">
                                <?php
                                $meeting_starts = new DateTime(get_field('meeting_starts', $p->ID));
                                if (date("Y") == $meeting_starts->format("Y")) {
                                    echo $meeting_starts->format("d.m. H:i");
                                } else {
                                    echo $meeting_starts->format("d.m.Y H:i");
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                        ?>
                        <p>Ei kokouksia</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>