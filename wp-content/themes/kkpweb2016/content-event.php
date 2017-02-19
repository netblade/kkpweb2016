<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

kkpweb2016_set_last_edit_post($post);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header>
    <div class="row">
        <div class="col-lg-6">
            <h4>Ajankohta</h4>
            <table>
                <tr>
                    <th>Alkaa:&nbsp;&nbsp;</th>
                    <td><?php echo kkpweb2016_get_datestring(get_field('event_start'), true); ?></td>
                </tr>
                <tr>
                    <th>Loppuu:&nbsp;&nbsp;</th>
                    <td>
                        <?php echo kkpweb2016_get_datestring(get_field('event_end'), true); ?>
                    </td>
                </tr>
            </table>
            <h4>Paikka</h4>
            <?php
            $event_place_str = "";

            $other_place = get_field('place_other');
            if ($other_place != "") {
                $event_place_str = $other_place;
            } else {
                $value = get_field("place");
                $label = $value['label'];
                $event_place_str = $label;
            }
            echo $event_place_str;
            ?>


            <?php

            $additional_details = "";

            $email_str = "";

            $person = get_field('info_person_kipinat');

            if (trim($person) == "")
            {
                $person = get_field('info_person_other');
            }

            if (trim($person) != "")
            {
                $person_post = get_post($person);

                $email_str = kkpweb2016_get_person_email($person);

                if ($person_post != null) {

                    $additional_details = '<a href="'.get_permalink($person).'">'.$person_post->post_title."</a>";

                    $phone_str = kkpweb2016_get_person_phone($person);
                    if (trim($phone_str) != "") {
                        $additional_details .= "<br />p. ". $phone_str;
                    }
                }
            }

            if (trim($email_str) != "") {
                $additional_details .= '<br />@: ' . $email_str;
            }

            if (trim($additional_details) == "") {
                $additional_details = trim(get_field('info_manual_text'));
            }

            $additional_details_link = kkpweb2016_get_extra_info_link($post->ID);

            if (trim($additional_details) != "" || $additional_details_link != "") {
            ?>
            <h4>Lis&auml;tiedot</h4>
            <?php 
            echo $additional_details; 
            echo $additional_details_link; 
            }
            ?>
        </div>
        <div class="col-lg-6">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

    

    
    <?php edit_post_link( __( 'Edit', 'kkpweb2016' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

</article>
