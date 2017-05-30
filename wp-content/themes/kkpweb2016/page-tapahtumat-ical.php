<?php
/*
Template Name: Tapahtumat ical
 */
header('Content-Type: text/calendar');
require_once("zapcallib/zapcallib.php");
$icalobj = new ZCiCal();

$show_events = true;
if (strstr($post->post_name, "kokoukset")) {
    $show_events = false;
}


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

global $default_timezone;


if ($show_events) {


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

            $full_day = get_field('event_full_day', $p->ID);
            $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);
            $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $p->post_title));
            $start_date = new DateTime(get_field('event_start', $p->ID), $default_timezone);


            $end_date = new DateTime(get_field('event_end', $p->ID), $default_timezone);


            if ($full_day) {
                $event_start = $start_date->format("Y-m-d");
                $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));

                $event_end = $end_date->format("Y-m-d");
                $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));
            }
            else
            {
                $event_start = $start_date->format("Y-m-d H:iO");
                $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));

                $event_end = $end_date->format("Y-m-d H:iO");
                $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));
            }


            $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime($p->post_date_gmt)));

            $eventobj->addNode(new ZCiCalDataNode("UID:" . get_permalink($p->ID)));
            $eventobj->addNode(new ZCiCalDataNode("URL:" . get_permalink($p->ID)));


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
            $eventobj->addNode(new ZCiCalDataNode("LOCATION:" . $event_place_str));
        }
    }

}
else
{


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

            $full_day = get_field('meeting_full_day', $p->ID);
            $eventobj = new ZCiCalNode("VEVENT", $icalobj->curnode);
            $eventobj->addNode(new ZCiCalDataNode("SUMMARY:" . $p->post_title));
            $start_date = new DateTime(get_field('meeting_starts', $p->ID), $default_timezone);

            if ($full_day) {
                $event_start = $start_date->format("Y-m-d");
                $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));

                $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_start)));
            }
            else
            {
                $event_start = $start_date->format("Y-m-d H:iO");
                $eventobj->addNode(new ZCiCalDataNode("DTSTART:" . ZCiCal::fromSqlDateTime($event_start)));

                $duration = get_field('meeting_duration', $p->ID);

                if (empty($duration) || strlen($duration) == 0) {
                    $duration = 60;
                }

                $end_date = $start_date;

                $end_date->modify('+'.$duration.' minutes');

                $event_end = $end_date->format("Y-m-d H:iO");
                $eventobj->addNode(new ZCiCalDataNode("DTEND:" . ZCiCal::fromSqlDateTime($event_end)));
            }


            $eventobj->addNode(new ZCiCalDataNode("DTSTAMP:" . ZCiCal::fromSqlDateTime($p->post_date_gmt)));

            $eventobj->addNode(new ZCiCalDataNode("UID:" . get_permalink($p->ID)));
            $eventobj->addNode(new ZCiCalDataNode("URL:" . get_permalink($p->ID)));


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
            $eventobj->addNode(new ZCiCalDataNode("LOCATION:" . $event_place_str));
        }
    }
}

echo $icalobj->export();