<?php
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
                    kkpweb2016_get_template_part($post);
                }
                ?>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>