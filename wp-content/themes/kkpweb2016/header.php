<?php
global $kkpweb2016_template_options;

global $navigation_root_post;

$navigation_root_post = $post;

switch ($post->post_type) {
    case "event":
    case "meeting":
        $navigation_root_post = get_post($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_events']);
        break;
    case "news":
        $navigation_root_post = get_post($kkpweb2016_template_options['kkpweb2016_settings_frontpage_boxes_news']);
        break;
    case "person":
    case "person_other":
        $navigation_root_post = get_post($kkpweb2016_template_options['kkpweb2016_settings_misc_contacts_parent_page']);
        break;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="" />
    <meta name="author" content="Kilon Kipin�t ry" />
    <link rel="apple-touch-icon" sizes="57x57" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/kkpweb2016/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/wp-content/themes/kkpweb2016/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/kkpweb2016/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/wp-content/themes/kkpweb2016/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/kkpweb2016/favicon/favicon-16x16.png">
    <link rel="manifest" href="/wp-content/themes/kkpweb2016/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#006F00">
    <meta name="msapplication-TileImage" content="/wp-content/themes/kkpweb2016/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#006F00">

    <title><?php echo get_the_title(); ?></title>


    <?php wp_head(); ?>

    <!-- Bootstrap core CSS -->
    <link href="/wp-content/themes/kkpweb2016/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <link href="/wp-content/themes/kkpweb2016/style.min.css" rel="stylesheet" />


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body <?php body_class(); ?>>


    <div id="fb-root"></div>
    <script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    <div id="wrapper" class="container">
        <div class="header">
            <div id="header_top" class="row">
                
                <div class="col-lg-8 col-md-4 col-sm-4" id="header_logo_container">
                    <a href="/">
                        <img src="/wp-content/themes/kkpweb2016/img/header_logo.png" />
                    </a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 text-right" style="float:right; display:inline-block;" id="header_links">

                    
                    <?php

                    for ($i = 0; $i < 3; $i++) {

                        $link_title = $kkpweb2016_template_options['kkpweb2016_settings_template_header_link_'.$i.'_title'];

                        if ($link_title != null && strlen($link_title) > 0) {
                            $link_page = get_post($kkpweb2016_template_options['kkpweb2016_settings_template_header_link_'.$i.'_page']);

                            if ($link_page != null) {
                    ?>
                                        <a href="<?php echo get_permalink($link_page->ID); ?>"><?php echo $link_title; ?></a>
                    <?php
                            }
                        }

                    }

                    ?>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <form method="post" action="search.php">
                        <div class="input-group" id="search_container">
                            <input placeholder="HAE" name="search" type="text" class="form-control" />
                            <span class="input-group-addon" id="searchSubmitContainer">
                                <button type="submit" class="btn btn-default" id="searchSubmit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                    <div id="socialLinks">
                        <div id="fbLink">
                            <a href="http://www.facebook.com/kilonkipinat" target="_blank">
                                <img src="/wp-content/themes/kkpweb2016/img/facebook.png" height="22" width="22" />
                            </a>
                        </div>
                        <div id="instagramLink">
                            <a href="https://www.instagram.com/kilonkipinat/" target="_blank">
                                <img src="/wp-content/themes/kkpweb2016/img/Instagram2016_col-128px.png" height="22" width="22" />
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Static navbar -->
            <nav id="header_top_navi" class="navbar navbar-default">
                <div class="container-fluid container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <?php
                        echo kkpweb2016_main_navi($navigation_root_post);
                        ?>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
        </div>
