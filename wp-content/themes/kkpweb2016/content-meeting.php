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
            <?php

            $event_time_str = "";
            $event_starts = new DateTime(get_field('event_start'));

            $event_time_str = $event_starts->format("d.m.Y H:i");

            echo $event_time_str;

            ?>
            <h4>Paikka</h4>
            <?php
            $event_place_str = "";

            $other_place = get_field('place_other');
            if ($other_place != "") {
                $event_place_str = $other_place;
            } else {
                $value = get_field("place");
                if (is_array($value) && array_key_exists('label', $value)) {
                    $label = $value['label'];
                    $event_place_str = $label;
                }
            }
            echo $event_place_str;
            ?>


            <?php

            $additional_details = "";

            $email = "";
            $email_str = "";

            $person = get_field('info_person_kipinat');

            if (trim($person) == "")
            {
                $person = get_field('info_person_other');
            }
            if (trim($person) != "")
            {
                $person_post = get_post($person);
                if ($person_post != null) {

                    $additional_details = '<a href="'.get_permalink($person).'">'.$person_post->post_title."</a>";

                    $phone = get_field('mobile', $person);
                    if ($phone != null && trim($phone) != "") {
                        $phone_trim = str_replace(" ", "", str_replace("-", "", trim($phone)));
                        if ($phone_trim != "") {
                            $phone_str = '<script type="text/javascript">document.write("'.str_rot13('<a class=\"more_info_phone\" href=\"tel:'.$phone_trim.'\" rel=\"nofollow\">'.$phone.'</a>').'".replace(/[a-zA-Z]/g,function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));</script>';
                            $additional_details .= "<br />p. ". $phone_str;
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
                $additional_details .= '<br />@: ' . $email_str;
            }

            if (trim($additional_details) == "") {
                $additional_details = get_field('info_manual_text');
            }

            if (trim($additional_details) != "") {
            ?>
            <h4>Lis&auml;tiedot</h4>
            <?php echo $additional_details; ?>
            <?php

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
