<?php
/*
Template Name: Etusivu, tmp
*/
get_header();

global $kkpweb2016_template_options;

?>
<div class="content" id="content">
    <main id="main" class="site-main" role="main">
        <div class="row">
            <div class="col-lg-12">
                <?php
		// Start the loop.
		while ( have_posts() ) {
            the_post();
			// Include the page content template.
			kkpweb2016_get_template_part($post);
        }
                ?>
            </div>

        </div>
        <br />
        <div class="row">
            <div class="col-lg-6">
                <?php echo do_shortcode('[instagram-feed id="3055900978" showheader="false"]'); ?>
            </div>
            <div class="col-lg-6">
                <div class="fb-page" data-href="https://www.facebook.com/kilonkipinat" data-tabs="timeline" data-width="540" data-height="740" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/kilonkipinat" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/kilonkipinat">Kilon Kipinät</a>
                    </blockquote>
                </div>
            </div>
        </div>
        <br />
    </main>
</div>
<?php
 get_footer();
?>