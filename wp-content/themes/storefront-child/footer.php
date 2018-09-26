    </div>
    <!-- Page Content END -->
    <!-- Footer -->
    <div class="clear"></div>
    <footer id="footer" class="bg-dark dark">

    <div class="container">
        <!-- Footer 1st Row -->
        <div class="footer-first-row row">
            <div class="col-lg-3 text-left">
                <h5 class="text-muted">Western Lake Chinese Seafood Restaurant</h5>
                4989 Victoria Dr <br>
                V5P 3T7 Vancouver <br>
                (604) 321-6862 <br>
                info@westernlake.ca
            </div>
            <div class="col-lg-4">
                <table class="table table-borderless">
                    <tr>
                        <td><h5 class="text-muted">Pick up</h5></td>
                    </tr>
                    <?php 
                    global $pickup_hours;
                    $weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                    for ($i = 0; $i < count($weekdays); $i++) {
                        echo '<tr><td><strong>' . $weekdays[$i] . ': </strong></td><td>&nbsp;</td><td>' . $pickup_hours[$i]->start_hour . ' - ' . $pickup_hours[$i]->close_start_hour . '</td></tr>';
                        echo '<tr><td></td><td>&nbsp;</td><td>' . $pickup_hours[$i]->close_end_hour . ' - ' . $pickup_hours[$i]->end_hour . '</td></tr>';
                    }
                    ?>
                </table>
            </div>
            <div class="col-lg-5">
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
            <span class="text-muted">© Copyright Western Lake Chinese Seafood Restaurant <?php echo date('Y', time()); ?>. Made with love by James Zhao.</span>
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
            <?php 
            global $woocommerce;
            $items = $woocommerce->cart->get_cart();
            foreach ($items as $item => $values) {
                $_product = wc_get_product($values['data']->get_id());
                ?>
                <tr>
                    <td class="title">
                        <span class="name"><?php echo $_product->get_title();?></span>
                    </td>
                    <td class="price"><?php echo get_post_meta($values['product_id'], '_price', true);?></td>
                    <td class="quantity">
                        x<?php echo $values['quantity'];?>
                    </td>
                    <td class="actions">
                        <a href="#" class="action-icon"><i class="ti ti-close"></i></a>
                    </td>
                    
                </tr>
                <?php
            }
            ?>
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
    <a href="/checkout" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span>Go to checkout</span></a>
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

    <!-- JS Plugins -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/jquery/dist/jquery.min.js"></script>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBqnyk9JGW2XOblOw26-C48h1djj18imo"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/tether/dist/js/tether.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/jquery.appear/jquery.appear.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/jquery.scrollto/jquery.scrollTo.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/jquery.localscroll/jquery.localScroll.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/twitter-fetcher/js/twitterFetcher_min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/skrollr/dist/skrollr.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/plugins/animsition/dist/js/animsition.min.js"></script>
    <!-- JS Core -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/core.js"></script>
