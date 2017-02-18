<?php
/*
Template Name: Ryhm&auml;
 */
global $kkpweb2016_template_options;
global $navigation_root_post;
get_header();
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
                if (get_field('show_meeting_time')) {
                    $meeting_repeat = get_field('meeting_repeat');
                    $meeting_day = get_field('meeting_day');
                    $meeting_time = get_field('meeting_time');
                    $meeting_time_free = get_field('meeting_time_free');
                    $meeting_place = get_field('meeting_place');
                    $meeting_place_other = get_field('meeting_place_other');
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h4>Kokousaika</h4>
                        <?php
                    $show_time= false;
                        switch ($meeting_repeat["value"]) {
                            case "weekly":
                            case "biweekly":
                            case "monthly":
                            case "when_needed":
                                echo $meeting_repeat["label"];
                                $show_time = true;
                                break;
                            case "no_repeat":
                            default:
                                echo $meeting_time_free;
                                break;
                        }
                        if ($show_time && is_array($meeting_day) && array_key_exists('label', $meeting_day)) {
                            echo ", " . $meeting_day['label'] . " " . $meeting_time;
                        }
                        ?>
                        <?php
                        if ((is_array($meeting_place) && array_key_exists('label', $meeting_place) && trim($meeting_place['label']) != "") || trim($meeting_place_other) != "")
                        {
                        ?>
                        <h4>Kokouspaikka</h4>
                        <?php
                            if (trim($meeting_place_other) != "") {
                                echo $meeting_place_other;
                            } else {
                                echo $meeting_place['label'];
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
                }
                        ?>
                <hr />
                        <div class="row">
                            <div class="col-lg-12" id="members_wrapper">
                                <?php
                        $members = get_field('members');
                        $row_counter = -1;
                        if (is_array($members) && count($members) > 0) {
                            $members_person_view = get_field('members_person_view');
                            if (trim($members_person_view) == "") {
                                $members_person_view = "info";
                            }

                            echo "<h4>Henkil&ouml;t</h4>";
                            foreach($members as $row) {
                                if (!is_array($row)) {
                                    continue;
                                }
                                switch ($row['row_type']) {
                                    case "spacer":
                                        if ($row_counter > 0) {
                                            echo '</div>';
                                            $row_counter = -1;
                                        }
                                        echo "<hr />";
                                        break;
                                    case "headline":
                                        if ($row_counter > 0) {
                                            echo '</div>';
                                            $row_counter = -1;
                                        }
                                        if (trim($row['title']) != "") {
                                            echo "<h2>" . $row['title'] . "</h2>";
                                        }
                                        break;
                                    case "person":
                                        $person = $row['person'];
                                        $other_name = trim($row['other_name']);
                                        if ($person != null && property_exists($person, "ID")) {
                                            if ($row_counter < 0) {
                                                echo '<div class="row">';
                                                $row_counter = 0;
                                            }
                                            if ($row_counter > 3) {
                                                echo '</div><div class="row">';
                                                $row_counter = 0;
                                            }
                                            $row_counter++;
                                            $permalink = get_permalink($person->ID);
                                ?>
                                <div class="col-lg-3 members_member">
                                    <h3>
                                        <?php echo $row['title']; ?>
                                    </h3>
                                    <?php
                                    if (strstr($members_person_view, "image"))
                                    {
                                    ?>
                                    <div class="members_image">
                                        <?php
                                            $person_image = get_field('image', $person->ID);
                                            if (is_array($person_image) && array_key_exists('sizes', $person_image)
                                                && is_array($person_image['sizes']) && array_key_exists('thumbnail', $person_image['sizes'])
                                                && array_key_exists('thumbnail-width', $person_image['sizes']) && is_numeric($person_image['sizes']['thumbnail-width']) && (int) $person_image['sizes']['thumbnail-width'] <= 150
                                                && array_key_exists('thumbnail-height', $person_image['sizes']) && is_numeric($person_image['sizes']['thumbnail-height']) && (int) $person_image['sizes']['thumbnail-height'] <= 150)
                                            {
                                        ?>
                                        <a href="<?php echo $permalink; ?>">
                                            <img src="<?php echo $person_image['sizes']['thumbnail']; ?>" />
                                        </a>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <h4><a href="<?php echo $permalink; ?>"><?php echo $person->post_title; ?></a></h4>
                                    <?php
                                    if (strstr($members_person_view,"info")) {
                                        $phone_str = kkpweb2016_get_person_phone($person->ID);
                                        if ($phone_str != "") {
                                    ?>
                                    <span class="person_contact_info">
                                        p. <?php echo $phone_str; ?>
                                    </span>
                                    <?php
                                        }

                                        $email_str = kkpweb2016_get_person_email($person->ID);
                                        if ($email_str != "") {
                                            echo '<span class="person_contact_info">@: ' . $email_str . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                                        } elseif ($other_name != "") {
                                ?>
                                <div class="col-lg-3 members_member">
                                    <h3>
                                        <?php echo $row['title']; ?>
                                    </h3>
                                    <div class="members_image"></div>
                                    <h4>
                                        <a href="<?php echo $permalink; ?>">
                                            <?php echo $other_name ?>
                                        </a>
                                    </h4>
                                </div>
                                <?php
                                        }
                                        break;
                                }
                            }
                            if ($row_counter > 0) {
                                echo '</div>';
                            }
                        }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
    </main>
</div>

<?php get_footer(); ?>