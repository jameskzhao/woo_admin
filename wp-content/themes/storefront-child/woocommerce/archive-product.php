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
            <!-- Section bg image -->
            <section id="bg-image" class="section section-lg dark bg-dark">
                <!-- BG Image -->
                <div class="bg-image bg-parallax skrollable skrollable-between" data-top-bottom="background-position-y: 30%" data-bottom-top="background-position-y: 70%" style="background-image: url('http://westernlake.ca/wp-content/uploads/2015/07/fried_prawn_spring_rolls.jpg-e1439160997647.jpg'); background-position-y: 44.8024%;">
                    <img src="http://westernlake.ca/wp-content/uploads/2015/07/fried_prawn_spring_rolls.jpg-e1439160997647.jpg" alt="" style="display: none;">
                </div>
                <div class="container text-center">
                    <div class="col-lg-8 push-lg-2">
                        <h2 class="mb-3">Would you like to visit Us?</h2>
                        <h5 class="text-muted">Book a table even right now or make an online order!</h5>
                        <a href="#order-online" class="btn btn-primary">
                            <span>Order Online</span>
                        </a>
                    </div>
                </div>
            </section>
            <section id="order-online">
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
                    <div class="row no-gutters">
                        <div class="col-md-3">
                            <!-- Menu Navigation -->
                            <nav id="menu-navigation" class="stick-to-content" data-local-scroll>
                                <ul class="nav nav-menu bg-dark dark">
                                    <?php
                                    foreach ($product_categories as $category) {
                                        echo '<li><a href="#' . $category->name . '">' . $category->name . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-md-9">
                            <?php
                                foreach ($product_categories as $category) {
                                    $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
                                    $image = wp_get_attachment_url($thumbnail_id);
                                    ?>
                                    <div id="<?php echo $category->name; ?>" class="menu-category">
                                        <div class="menu-category-title">
                                            <div class="bg-image"><img src="<?php echo $image; ?>" alt=""></div>
                                            <h2 class="title"><?php echo $category->name; ?></h2>
                                        </div>
                                        <?php
                                        $args = array(
                                                'post_type' => 'product',
                                                'posts_per_page' => -1,
                                                'product_cat' => $category->name,
                                        );
                                        $loop = new WP_Query($args);

                                        while ($loop->have_posts()): $loop->the_post();
                                            global $product;
                                            ?>
                                            <div class="menu-item menu-list-item">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-2">
                                                        <?php
                                                        $image_src = wp_get_attachment_image_src($product->image_id);
                                                        if ($image_src) {
                                                            echo '<img src="' . $image_src[0] . '">';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-5 mb-2 mb-sm-0">
                                                        <h6 class="mb-0"><?php echo $product->name; ?></h6>
                                                        <span class="text-muted text-sm"><?php echo $product->description; ?></span>
                                                    </div>
                                                    <div class="col-sm-5 text-sm-right">
                                                        <span class="text-md mr-4"> $<?php echo $product->regular_price; ?></span>
                                                        <button class="btn btn-outline-secondary btn-sm" data-target="#productModal" data-toggle="modal"><span>Add to cart</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- menu-item -->
                                        <?php endwhile; ?>
                                    </div>
                                    <!-- menu-category -->
                                    <?php
                                }
                                // end of foreach menu category
                                ?>


                        </div>
                        <!-- col-md-9 -->
                    </div>
                    <!-- row no-gutters -->
                </div>
                <!-- page-content -->
            </section>
            
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