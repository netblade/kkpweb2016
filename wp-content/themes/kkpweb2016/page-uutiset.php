<?php
/*
Template Name: Uutiset
 */
get_header();
global $kkpweb2016_template_options;
global $navigation_root_post;
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
                    <div class="col-lg-12">
                        <?php
                        $posts_per_page = 2;
                        $page = 1;
                        $offset = 0;
                        if (array_key_exists("news_page", $_GET) && $_GET["news_page"] != "" && is_numeric($_GET["news_page"])) {
                            if ((int) $_GET["news_page"] > 0) {
                                $page = (int) $_GET["news_page"];

                                if ($page > 1) {
                                    $offset = ($page - 1) * $posts_per_page;
                                }
                            }
                        }

                        $posts = get_posts(array(
                            'posts_per_page'	=> $posts_per_page + 1,
                            'offset'            => $offset,
                            'post_type'			=> 'news',
                            'order'				=> 'DESC',
                            'orderby'			=> 'date'
                        ));
                        $count = 0;
                        if( $posts ) {
                            foreach( $posts as $p ) {
                                $count++;
                                if ($count > $posts_per_page) {
                                    break;
                                }
                        ?>

                        <div class="row event_header">
                            <div class="col-lg-8">
                                <a href="<?php echo get_permalink($p->ID); ?>">
                                    <?php echo $p->post_title; ?>
                                </a>
                            </div>
                            <div class="col-lg-4 text-right">
                                <?php
                                    $published = new DateTime($p->post_date);
                                    echo $published->format("d.m.Y H:i")
                                ?>
                            </div>
                        </div>

                        <br />

                        <?php
                            }
                        }
                        ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                if ($page > 1) {
                                    ?>
                                    <a href="?news_page=<?php echo $page-1; ?>">Edellinen</a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-lg-6 text-right">
                                <?php
                                if ($count > $posts_per_page) {
                                ?>
                                <span class="text-right">
                                    <a href="?news_page=<?php echo $page+1; ?>">Seuraava</a>
                                </span>
                                <?php
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>