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
		<form name="checkout" method="post" class="checkout woocommerce-checkout <?php echo $wrapper_classes; ?>" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
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
						<?php if ( $checkout->get_checkout_fields() ) :?>
						<div class="col2-set" id="customer_details">
							<h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Customer Details</h4>
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</form>
		
	</div>
</section>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

