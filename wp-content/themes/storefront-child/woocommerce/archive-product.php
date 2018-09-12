<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;


$orderby = 'name';
$order = 'asc';
$hide_empty = true;
$cat_args = array(
    'orderby' => $orderby,
    'order' => $order,
    'hide_empty' => $hide_empty,
);

$product_categories = get_terms('product_cat', $cat_args);
get_header();
?>
        <!-- Content -->
        <div id="content">

            <!-- Page Title -->
            <div class="page-title bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 push-lg-4">
                            <h1 class="mb-0">Menu List</h1>
                            <h4 class="text-muted mb-0">Some informations about our restaurant</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                <div class="container">
                    <div class="row no-gutters">
                        <div class="col-md-3">
                            <!-- Menu Navigation -->
                            <nav id="menu-navigation" class="stick-to-content" data-local-scroll>
                                <ul class="nav nav-menu bg-dark dark">
                                    <?php 
                                    foreach($product_categories as $category){
                                        echo '<li><a href="#'.$category->name.'">'.$category->name.'</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-9">
                            <?php 
                                foreach($product_categories as $category){
                                    $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); 
                                    $image = wp_get_attachment_url( $thumbnail_id ); 
                                    
                                    ?>
                                    <div id="<?php echo $category->name;?>" class="menu-category">
                                        <div class="menu-category-title">
                                            <div class="bg-image"><img src="<?php echo $image;?>" alt=""></div>
                                            <h2 class="title"><?php echo $category->name;?></h2>
                                        </div>
                                        <?php 
                                        $args = array(
                                            'post_type'      => 'product',
                                            'posts_per_page' => -1,
                                            'product_cat'    => $category->name,
                                        );

                                        $loop = new WP_Query( $args );

                                        while ( $loop->have_posts() ) : $loop->the_post();
                                            global $product;
                                            
                                            // echo '<br/>';
                                            // echo '<br /><a href="'.get_permalink().'"><img src="'.my_get_the_product_thumbnail_url().'"> '.get_the_title().'</a>';
                                            ?>
                                            <div class="menu-item menu-list-item">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-2">
                                                    <?php 
                                                    $image_src = wp_get_attachment_image_src($product->image_id);
                                                    if($image_src){
                                                        
                                                        echo '<img src="'.$image_src[0].'">';
                                                    }
                                                    ?>
                                           
                                                    </div>
                                                    <div class="col-sm-5 mb-2 mb-sm-0">
                                                        <h6 class="mb-0"><?php echo $product->name; ?></h6>
                                                        <span class="text-muted text-sm"><?php echo $product->description;?></span>
                                                    </div>
                                                    <div class="col-sm-5 text-sm-right">
                                                        <span class="text-md mr-4"> $<?php echo $product->regular_price; ?></span>
                                                        <button class="btn btn-outline-secondary btn-sm" data-target="#productModal" data-toggle="modal"><span>Add to cart</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        endwhile;
                                        ?>
                                        
                                    </div>
                                    <?php
                                }
                            ?>
                            
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer id="footer" class="bg-dark dark">

                <div class="container">
                    <!-- Footer 1st Row -->
                    <div class="footer-first-row row">
                        <div class="col-lg-3 text-center">
                            <a href="index.html"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-light.svg" alt="" width="88" class="mt-5 mb-5"></a>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <h5 class="text-muted">Latest news</h5>
                            <ul class="list-posts">
                                <li>
                                    <a href="blog-post.html" class="title">How to create effective webdeisign?</a>
                                    <span class="date">February 14, 2015</span>
                                </li>
                                <li>
                                    <a href="blog-post.html" class="title">Awesome weekend in Polish mountains!</a>
                                    <span class="date">February 14, 2015</span>
                                </li>
                                <li>
                                    <a href="blog-post.html" class="title">How to create effective webdeisign?</a>
                                    <span class="date">February 14, 2015</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <h5 class="text-muted">Subscribe Us!</h5>
                            <!-- MailChimp Form -->
                            <form action="//suelo.us12.list-manage.com/subscribe/post-json?u=ed47dbfe167d906f2bc46a01b&amp;id=24ac8a22ad" id="sign-up-form" class="sign-up-form validate-form mb-3" method="POST">
                                <div class="input-group">
                                    <input name="EMAIL" id="mce-EMAIL" type="email" class="form-control" placeholder="Tap your e-mail..." required>
                                    <span class="input-group-btn">
                                    <button class="btn btn-primary btn-submit" type="submit">
                                        <span class="description">Subscribe</span>
                                    <span class="success">
                                            <svg x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/></svg>
                                        </span>
                                    <span class="error">Try again...</span>
                                    </button>
                                    </span>
                                </div>
                            </form>
                            <h5 class="text-muted mb-3">Social Media</h5>
                            <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
                            <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
                            <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                    <!-- Footer 2nd Row -->
                    <div class="footer-second-row">
                        <span class="text-muted">Copyright Soup 2017©. Made with love by Suelo.</span>
                    </div>
                </div>

                <!-- Back To Top -->
                <a href="#" id="back-to-top"><i class="ti ti-angle-up"></i></a>

            </footer>
            <!-- Footer / End -->

        </div>
        <!-- Content / End -->

        <!-- Panel Cart -->
        <div id="panel-cart">
            <div class="panel-cart-container">
                <div class="panel-cart-title">
                    <h5 class="title">Your Cart</h5>
                    <button class="close" data-toggle="panel-cart"><i class="ti ti-close"></i></button>
                </div>
                <div class="panel-cart-content">
                    <table class="table-cart">
                        <tr>
                            <td class="title">
                                <span class="name"><a href="#productModal" data-toggle="modal">Pizza Chicked BBQ</a></span>
                                <span class="caption text-muted">26”, deep-pan, thin-crust</span>
                            </td>
                            <td class="price">$9.82</td>
                            <td class="actions">
                                <a href="#productModal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a>
                                <a href="#" class="action-icon"><i class="ti ti-close"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="title">
                                <span class="name"><a href="#productModal" data-toggle="modal">Beef Burger</a></span>
                                <span class="caption text-muted">Large (500g)</span>
                            </td>
                            <td class="price">$9.82</td>
                            <td class="actions">
                                <a href="#productModal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a>
                                <a href="#" class="action-icon"><i class="ti ti-close"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="title">
                                <span class="name"><a href="#productModal" data-toggle="modal">Extra Burger</a></span>
                                <span class="caption text-muted">Small (200g)</span>
                            </td>
                            <td class="price text-success">$0.00</td>
                            <td class="actions">
                                <a href="#productModal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a>
                                <a href="#" class="action-icon"><i class="ti ti-close"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="title">
                                <span class="name">Weekend 20% OFF</span>
                            </td>
                            <td class="price text-success">-$8.22</td>
                            <td class="actions"></td>
                        </tr>
                    </table>
                    <div class="cart-summary">
                        <div class="row">
                            <div class="col-7 text-right text-muted">Order total:</div>
                            <div class="col-5"><strong>$21.02</strong></div>
                        </div>
                        <div class="row">
                            <div class="col-7 text-right text-muted">Devliery:</div>
                            <div class="col-5"><strong>$3.99</strong></div>
                        </div>
                        <hr class="hr-sm">
                        <div class="row text-lg">
                            <div class="col-7 text-right text-muted">Total:</div>
                            <div class="col-5"><strong>$24.21</strong></div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="checkout.html" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span>Go to checkout</span></a>
        </div>

        <!-- Panel Mobile -->
        <nav id="panel-mobile">
            <div class="module module-logo bg-dark dark">
                <a href="#">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-light.svg" alt="" width="88">
                </a>
                <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
            </div>
            <nav class="module module-navigation"></nav>
            <div class="module module-social">
                <h6 class="text-sm mb-3">Follow Us!</h6>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i class="fa fa-google"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i class="fa fa-twitter"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i class="fa fa-youtube"></i></a>
                <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i class="fa fa-instagram"></i></a>
            </div>
        </nav>

        <!-- Body Overlay -->
        <div id="body-overlay"></div>

    </div>

    <!-- Modal / Product -->
    <div class="modal fade" id="productModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lg dark bg-dark">
                    <div class="bg-image"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/photos/modal-add.jpg" alt=""></div>
                    <h4 class="modal-title">Specify your dish</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
                </div>
                <div class="modal-product-details">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h6 class="mb-0">Boscaiola Pasta</h6>
                            <span class="text-muted">Pasta, Cheese, Tomatoes, Olives</span>
                        </div>
                        <div class="col-3 text-lg text-right">$9.00</div>
                    </div>
                </div>
                <div class="modal-body panel-details-container">
                    <!-- Panel Details / Size -->
                    <div class="panel-details">
                        <h5 class="panel-details-title">
                            <label class="custom-control custom-radio">
                            <input name="radio_title_size" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                        </label>
                            <a href="#panelDetailsSize" data-toggle="collapse">Size</a>
                        </h5>
                        <div id="panelDetailsSize" class="collapse show">
                            <div class="panel-details-content">
                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                    <input name="radio_size" type="radio" class="custom-control-input" checked>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Small - 100g ($9.99)</span>
                                </label>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                    <input name="radio_size" type="radio" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Medium - 200g ($14.99)</span>
                                </label>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                    <input name="radio_size" type="radio" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Large - 350g ($21.99)</span>
                                </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Panel Details / Additions -->
                    <div class="panel-details">
                        <h5 class="panel-details-title">
                            <label class="custom-control custom-radio">
                            <input name="radio_title_additions" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                        </label>
                            <a href="#panelDetailsAdditions" data-toggle="collapse">Additions</a>
                        </h5>
                        <div id="panelDetailsAdditions" class="collapse">
                            <div class="panel-details-content">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Tomato ($1.29)</span>
                                        </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Ham ($1.29)</span>
                                        </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Chicken ($1.29)</span>
                                        </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Cheese($1.29)</span>
                                        </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">Bacon ($1.29)</span>
                                        </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Panel Details / Other -->
                    <div class="panel-details">
                        <h5 class="panel-details-title">
                            <label class="custom-control custom-radio">
                            <input name="radio_title_other" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                        </label>
                            <a href="#panelDetailsOther" data-toggle="collapse">Other</a>
                        </h5>
                        <div id="panelDetailsOther" class="collapse">
                            <textarea cols="30" rows="4" class="form-control" placeholder="Put this any other informations..."></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg" data-dismiss="modal"><span>Add to Cart</span></button>
            </div>
        </div>
    </div>

    <?php get_footer();?>