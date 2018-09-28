<?php

/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


wc_print_notices(); 
do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() );
?>
<section class="section bg-light">
	<div class="container">
		<div class="row">
			<div class="col-xl-4 push-xl-8 col-lg-5 push-lg-7">
				<div class="shadow bg-white stick-to-content mb-4">

					<div class="bg-dark dark p-4"><h5 class="mb-0"><?php _e( 'Your order', 'woocommerce' ); ?></h5></div>
					<div class="p-4">
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
						<div id="order_review" class="woocommerce-checkout-review-order">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-8 pull-xl-4 col-lg-7 pull-lg-5">
				<div class="bg-white p-4 p-md-5 mb-4">
					<h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Basic informations</h4>
					<div class="row mb-5">
						<div class="form-group col-sm-6">
							<label>Name:</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group col-sm-6">
							<label>Surename:</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group col-sm-6">
							<label>Street and number:</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group col-sm-6">
							<label>City:</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group col-sm-6">
							<label>Phone number:</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group col-sm-6">
							<label>E-mail address:</label>
							<input type="email" class="form-control">
						</div>
					</div>

					<h4 class="border-bottom pb-4"><i class="ti ti-wallet mr-3 text-primary"></i>Payment</h4>
					<div class="row text-lg">
						<div class="col-md-4 col-sm-6 form-group">
							<label class="custom-control custom-radio">
								<input type="radio" name="payment_type" class="custom-control-input">
								<span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span>
								<span class="custom-control-description">PayPal</span>
							</label>
						</div>
						<div class="col-md-4 col-sm-6 form-group">
							<label class="custom-control custom-radio">
								<input type="radio" name="payment_type" class="custom-control-input">
								<span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span>
								<span class="custom-control-description">Credit Card</span>
							</label>
						</div>
						<div class="col-md-4 col-sm-6 form-group">
							<label class="custom-control custom-radio">
								<input type="radio" name="payment_type" class="custom-control-input">
								<span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span>
								<span class="custom-control-description">Cash</span>
							</label>
						</div>
					</div>
				</div>
				<div class="text-center">
					<button class="btn btn-primary btn-lg"><span>Order now!</span></button>
				</div>
			</div>
		</div>
	</div>
</section>

<form name="checkout" method="post" class="checkout woocommerce-checkout <?php echo $wrapper_classes; ?>" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<div class="row pt-0 <?php echo $row_classes; ?>">
  	<div class="large-7 col  <?php echo $main_classes; ?>">
    <?php if ( $checkout->checkout_fields ) : ?>

  		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

  		<div id="customer_details">
  			<div class="clear">
  				<?php do_action( 'woocommerce_checkout_billing' ); ?>
  			</div>
  			<div class="clear">
  				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
  			</div>
  		</div>

  		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

  	<?php endif; ?>
  	</div><!-- large-7 -->

  	<div class="large-5 col">
      <?php if(get_theme_mod('checkout_sticky_sidebar', 0)) { ?>
      <div class="is-sticky-column">
      <div class="is-sticky-column__inner">
      <?php } ?>

  		<div class="col-inner <?php echo $sidebar_classes; ?>">
  			<div class="checkout-sidebar sm-touch-scroll">
  				
  			</div>
  		</div>

      <?php if(get_theme_mod('checkout_sticky_sidebar', 0)) { ?>
      </div>
      </div>
      <?php } ?>
  	</div><!-- large-5 -->

	</div><!-- row -->
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

