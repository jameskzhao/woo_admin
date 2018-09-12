<?php
/**
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */
?>
<!doctype html>
<html <?php language_attributes();?>>
<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url');?>">
    <!-- CSS Plugins -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/animate.css/animate.min.css" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/animsition/dist/css/animsition.min.css" />
    <!-- CSS Icons -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/themify-icons.css" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/font-awesome/css/font-awesome.min.css" />
    <!-- CSS Theme -->
    <link id="theme" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/themes/theme-beige.min.css" />
</head>
<body <?php body_class();?>>
    <!-- Body Wrapper -->
    <div id="body-wrapper" class="animsition">
        <!-- Header -->
        <header id="header" class="light">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Logo -->
                        <div class="module module-logo dark">
                            <a href="index.html">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/logo-light.svg" alt="" width="88">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <!-- Navigation -->
                        <nav class="module module-navigation left mr-4">
                            <ul id="nav-main" class="nav nav-main">
                                <?php 
                                $menu_array = get_header_nav('primary');
                                if($menu_array){
                                    foreach($menu_array as $single_menu_obj){
                                        if($single_menu_obj->wpse_children){
                                            echo '<li class="has-dropdown"><a href="#">'.$single_menu_obj->title.'</a>';
                                            echo '<div class="dropdown-container"><ul>';
                                            foreach($single_menu_obj->wpse_children as $single_submenu){
                                                echo '<li><a href="'.$single_submenu->url.'">'.$single_submenu->title.'</a></li>';
                                            }
                                            echo '</ul></div>';
                                            echo '</li>';
                                        }else{
                                            echo '<li><a href="'.$single_menu_obj->url.'">'.$single_menu_obj->title.'</a></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </nav>
                        <div class="module left">
                            <a href="menu-list-navigation.html" class="btn btn-outline-secondary"><span>Order</span></a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="#" class="module module-cart right" data-toggle="panel-cart">
                            <span class="cart-icon">
                            <i class="ti ti-shopping-cart"></i>
                            <span class="notification">2</span>
                            </span>
                            <span class="cart-value">$32.98</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header / End -->
        <!-- Header -->
        <header id="header-mobile" class="light">
            <div class="module module-nav-toggle">
                <a href="#" id="nav-toggle" data-toggle="panel-mobile"><span></span><span></span><span></span><span></span></a>
            </div>
            <div class="module module-logo">
                <a href="index.html">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/logo-horizontal-dark.svg" alt="">
                </a>
            </div>
            <a href="#" class="module module-cart" data-toggle="panel-cart">
                <i class="ti ti-shopping-cart"></i>
                <span class="notification">2</span>
            </a>
        </header>
        <!-- Header / End -->
        <div class="container">

        