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

    <div class="entry-content">
        <?php the_content(); ?>
    </div>

    <?php edit_post_link( __( 'Edit', 'kkpweb2016' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

</article>
