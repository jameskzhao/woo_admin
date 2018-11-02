<?php

/**
 *
 * @package storefront
 */
$store_settings = get_store_settings();

get_header();
$day_of_week = date('w', current_time('timestamp'));
$hours_today = find_hours_by_day($pickup_hours, $day_of_week);
?>
<!-- Content -->
<div id="content">
	<!-- Section bg image -->
	<section id="bg-image" class="section section-lg bg-dark" style="min-height:600px;">
		<!-- BG Image -->
		<div class="bg-image bg-parallax skrollable skrollable-between" data-top-bottom="background-position-y: 30%" data-bottom-top="background-position-y: 70%" style="background-image: url('http://westernlake.ca/wp-content/uploads/2015/07/fried_prawn_spring_rolls.jpg-e1439160997647.jpg'); background-position-y: 44.8024%;">
			<img src="<?php echo $store_settings->banner_url;?>" alt="" style="display: none;">
		</div>
		<div class="container text-center">
			
			<div class="col-lg-6 push-lg-3 order-button-wrapper">
				<ul class="nav nav-pills nav-fill mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" href="#pickup" data-toggle="tab" role="tab">Pickup</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#delivery" data-toggle="tab" role="tab">Delivery</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="pickup" class="tab-pane active" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-8">
									<select name="" id="" class="form-control">
										<option value="1">4989 Victoria Dr, Vancouver</option>
									</select>
								</div>
								<div class="col-sm-4">
									<a href="/shop?order_type=pickup" class="btn btn-dark">
										<span>Order Online</span>
									</a>
								</div>
							</div>
							
							
						</div>
						
					</div>
					<div id="delivery" class="tab-pane" role="tabpanel">
						<a href="/shop?order_type=delivery" class="btn btn-dark">
							<span>Order Online</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="hours" class="section">
		<div class="container">
			<div class="row text-center">
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-6 text-left">
							<table>
								<tr><th>Today</th></tr>
								<tr>
									<td>Pickup Times</td>
									<td>&nbsp;</td>
									<td>
										<?php echo $hours_today->start_hour . ' - ' . $hours_today->close_start_hour;?>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>&nbsp;</td>
									<td><?php echo $hours_today->close_end_hour . ' - ' . $hours_today->end_hour;?></td>
								</tr>
							</table>
						</div>
						<div class="col-lg-6 text-left">
							4989 Victoria Dr <br> V5P 3T7 Vancouver <br> (604) 321-6862
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>
	<section id="map" class="section" style="min-height:475px;">
		<div id="map" style="height:475px;"></div>
	</section>
	
</div>
<!-- Content / End -->
<script>
// Initialize and add the map
function initMap() {
	// The location of Uluru
	var uluru = {lat: -25.344, lng: 131.036};
	// The map, centered at Uluru
	var map = new google.maps.Map(
		document.getElementById('map'), {zoom: 4, center: uluru}
	);
	// The marker, positioned at Uluru
	var image = '<?php echo get_stylesheet_directory_uri(); ?>/assets/img/map-marker.png';
	var marker = new google.maps.Marker({position: uluru, map: map, icon:image});
}

</script>
<?php

get_footer();
?>
<script>
$(document).ready(function(){
	initMap();
});
</script>
</body>
</html>