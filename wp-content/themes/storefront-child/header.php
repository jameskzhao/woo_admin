<?php

/**
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */
global $pickup_hours, $woocommerce;

if(isset($_GET['order_type'])){
    WC()->session->set('order_type', $_GET['order_type']);
}
error_log(print_r(WC()->session->get('order_type'), true));
$pickup_hours = get_hours('pickup');
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $user = get_user_by('login', $username);
    /*** COMPARE FORM PASSWORD WITH WORDPRESS PASSWORD ***/
    if (!wp_check_password($password, $user->data->user_pass, $user->ID)) :
        return false;
    endif;
    wp_set_current_user($user->ID, $username);
    wp_set_auth_cookie($user->ID);
    if (is_user_logged_in()) : error_log('Login successful');
    endif;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
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
    <link id="theme" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" />
</head>
<body <?php body_class(); ?>>
    <!-- Body Wrapper -->
    <div id="body-wrapper" class="animsition">
        <!-- Header -->
        <header id="header" class="dark">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Logo -->
                        <div class="module">
                            <a href="/">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-light.svg" alt="" width="88">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <!-- Navigation -->
                        <nav class="module module-navigation left mr-4">
                            <ul id="nav-main" class="nav nav-main">
                                <li><a href="<?php echo is_home() ? '' : '/' ?>#">Home</a></li>
                                <!-- <li><a href="/shop">Order Online</a></li> -->
                                <li><a href="<?php echo is_home() ? '' : '/' ?>#map">About Us</a></li>
                                <li><a href="<?php echo is_home() ? '' : '/' ?>#footer">Contact</a></li>
                                <?php if (is_user_logged_in()) : $current_user = wp_get_current_user(); ?>
                                    <li class="has-dropdown">
                                        <a href="#"><?php echo $current_user->display_name; ?></a>
                                        <div class="dropdown-container">
                                            <ul>
                                                <li><a class="login_button" href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                <?php else : ?>
                                    <li><a href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-user"></i>&nbsp;Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <?php
                    global $woocommerce;
                    $cart_total = $woocommerce->cart->get_cart_total();
                    $cart_items_count = $woocommerce->cart->get_cart_contents_count();
                    ?>
                    <div class="col-md-2">
                        <a href="#" class="module module-cart right" data-toggle="panel-cart">
                            <span class="cart-icon">
                            <i class="ti ti-shopping-cart"></i>
                            <?php echo $cart_items_count > 0 ? '<span class="notification">' . $cart_items_count . '</span>' : '' ?>
                            </span>
                            <span class="cart-value"><?php echo $cart_total; ?></span>
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
                <a href="/">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-horizontal-dark.svg" alt="">
                </a>
            </div>
            <a href="#" class="module module-cart" data-toggle="panel-cart">
                <i class="ti ti-shopping-cart"></i>
                <?php echo $cart_items_count > 0 ? '<span class="notification">' . $cart_items_count . '</span>' : '' ?>
            </a>
        </header>
        <!-- Header / End -->
        <!-- Content -->
        <!-- Modal / Product -->
        <div class="modal fade" id="loginModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header modal-header-lg dark bg-dark">
                        <div class="bg-image"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/photos/modal-add.jpg" alt=""></div>
                        <h4 class="modal-title">Site Login</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
                    </div>
                    <form id="login" action="" method="post">
                        <div class="modal-body panel-details-container">
                            <label for="username">Username</label>
                            <input id="username" type="text" name="username" class="form-control">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" class="form-control">
                            <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a>
                        </div>
                        <button type="submit" class="modal-btn btn btn-secondary btn-block btn-lg"><span>Login</span></button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal / Product END -->
        <div id="content" class="container">
            <!-- Page Title END -->
            <!-- Page Content -->
            <div class="page-content">