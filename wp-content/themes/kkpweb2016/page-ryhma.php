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
                ?>
                <div class="row">
                    <div class="col-lg-12" id="members_wrapper">
                        <?php
                        $members = get_field('members');

                        $row_counter = -1;

                        if (is_array($members) && count($members) > 0) {
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
                                                <h4><a href="<?php echo $permalink; ?>"><?php echo $person->post_title; ?></a></h4>
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