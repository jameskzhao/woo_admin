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
                    <!-- col-md-3 end -->
                    <div class="col-md-9">
                        <?php
                        $products_array = array();
                        foreach ($product_categories as $category) {
                            $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
                            $image = wp_get_attachment_url($thumbnail_id);
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'product_cat' => $category->name,
                            );
                            $loop = new WP_Query($args);
                            ?>
                            <div id="<?php echo $category->name; ?>" class="menu-category">
                                <div class="menu-category-title">
                                    <div class="bg-image"><img src="<?php echo $image; ?>" alt=""></div>
                                    <h2 class="title"><?php echo $category->name; ?></h2>
                                </div>
                                <?php
                                while ($loop->have_posts()) : $loop->the_post();
                                global $product;
                                $current_product_data = $product->get_data();
                                $data_to_push = array(
                                    'id' => $current_product_data['id'],
                                    'name' => $current_product_data['name'],
                                    'prize' => $current_product_data['price'],
                                );
                                $data_to_push['variation'] = get_variation_products($current_product_data['id']);
                                array_push($products_array, $data_to_push);
                                $image_src = wp_get_attachment_image_src($product->image_id);
                                ?>
                                    <div class="menu-item menu-list-item">
                                        <div class="row align-items-center">
                                            <div class="col-sm-2">
                                                <?php
                                                if ($image_src) {
                                                    echo '<img src="' . $image_src[0] . '">';
                                                }
                                                ?>
                                            </div>
                                            <!-- col-sm-2 end -->
                                            <div class="col-sm-5 mb-2 mb-sm-0">
                                                <h6 class="mb-0"><?php echo $product->name; ?></h6>
                                                <span class="text-muted text-sm"><?php echo $product->description; ?></span>
                                            </div>
                                            <div class="col-sm-5 text-sm-right">
                                                <span class="text-md mr-4"> $<?php echo $product->price; ?></span>
                                                <button id="<?php echo $current_product_data['id'] ?>" class="btn btn-outline-secondary btn-sm" onclick="addToCart(this.id, '<?php echo $product->add_to_cart_url(); ?>')"><span>Add to cart</span></button>
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
                    <!-- col-md-9 end -->
                </div>
                <!-- row no-gutters -->
                <?php get_footer(); ?>        
            <!-- Modal / Product -->
            <div class="modal fade" id="productModal" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header modal-header-lg dark bg-dark">
                            <div class="bg-image"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/photos/modal-add.jpg" alt=""></div>
                            <h4 class="modal-title">Specify your dish</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
                        </div>
                        <div class="modal-body panel-details-container">
                            <!-- Panel Details / Size -->
                            <div class="panel-details">
                                <h5 class="panel-details-title">
                                    <label class="custom-control custom-radio">
                                        <input name="radio_title_size" type="radio" class="custom-control-input">
                                        <span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span>
                                    </label>
                                    <a href="#panelDetailsSize" data-toggle="collapse">Size</a>
                                </h5>
                                <div id="panelDetailsSize" class="collapse show">
                                    <div class="panel-details-content"></div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <button type="button" class="modal-btn btn btn-secondary btn-block btn-lg" data-dismiss="modal"><span>Add to Cart</span></button>
                    </div>
                </div>
            </div>
            <!-- Modal / Product END -->
    
    <script>
    var products = JSON.parse('<?php echo addslashes(json_encode($products_array)); ?>');
    function addToCart(id, url){
        var selectedProductId = id;
        var productDetails = getProductDetails(id);
        if(productDetails.variation.length>0){
            populateProductModal(productDetails);
        }else{
            addToWooCart(url);
        }
    }
    function populateProductModal(productDetails){
        var variations = productDetails.variation;
        if(variations.length>0){
            $("#panelDetailsSize > .panel-details-content").empty();
            for(var i=0; i<variations.length; i++){
                if(variations[i].price > 0){
                    $("#panelDetailsSize > .panel-details-content").append('<div class="form-group"><label class="custom-control custom-radio"><input name="radio_size" type="radio" class="custom-control-input"><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span><span class="custom-control-description">' + variations[i].name + ' ($' + variations[i].price + ')</span></label></div>');
                }
            }
        }
        $("#productModal").modal();
    }
    function addToWooCart(url){
        console.log('adding to cart. url is '+url);
        $.get('<?php echo get_stylesheet_directory_uri(); ?>'+'/server/check_store_open.php',{},function(data){
            if(data.store_closed=='N'){
                $.get(url,{},function(data){
                    location.reload();
                },'');
            }else{
                console.log(data);
                if(data.emergency_expire > data.current_timestamp){
                    var date = '  Estimated back time is ' + data.emergency_expire;
                }else{
                    var date = '';
                }
                alert('We are sorry but our online order is closed for now.' + date);
            }
        },'json');
        
    }
    function getProductDetails(id){
        for(var i=0; i<products.length; i++){
            if(products[i].id==id){
                return products[i];
            }
        }
    }
    </script>
</body>
</html>