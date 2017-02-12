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
        <div class="col-lg-4">
            <?php
            $phone = get_field('mobile');
            if ($phone != null && trim($phone) != "") {
                $phone_trim = str_replace(" ", "", str_replace("-", "", trim($phone)));
                if ($phone_trim != "") {
                    $phone_str = '<script type="text/javascript">document.write("'.str_rot13('<a class=\"more_info_phone\" href=\"tel:'.$phone_trim.'\" rel=\"nofollow\">'.$phone.'</a>').'".replace(/[a-zA-Z]/g,function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));</script>';
                }
            ?>
            <span class="person_contact_info">
                p. <?php echo $phone_str; ?>
            </span>
            <?php
            }
            $user = get_field('user');
            if ($user != null) {
                $userdata = get_userdata( $user['ID'] );
                $email = $userdata->user_email;
                if (trim($email) != "") {
                    $email_str = '<script type="text/javascript">document.write("'.str_rot13('<a class=\"more_info_email\" href=\"mailto:'.$email.'\" rel=\"nofollow\">'.$email.'</a>').'".replace(/[a-zA-Z]/g,function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));</script>';
                    echo '<span class="person_contact_info">@: ' . $email_str . '</span>';
                }
            }
            ?>
        </div>
        <div class="col-lg-4">
            <div class="person_image">
                <?php
                $person_image = get_field('image');
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
        </div>
        <div class="col-lg-4">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>

    

    
    <?php edit_post_link( __( 'Edit', 'kkpweb2016' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

</article>
