<?php

/**
 *
 * @package storefront
 */

get_header();
$day_of_week = date('w', current_time('timestamp'));
$hours_today = find_hours_by_day($pickup_hours, $day_of_week);
?>
<!-- Content -->
<div id="content">
	<!-- Section bg image -->
	<section id="bg-image" class="section section-lg dark bg-dark" style="min-height:600px;">
		<!-- BG Image -->
		<div class="bg-image bg-parallax skrollable skrollable-between" data-top-bottom="background-position-y: 30%" data-bottom-top="background-position-y: 70%" style="background-image: url('http://westernlake.ca/wp-content/uploads/2015/07/fried_prawn_spring_rolls.jpg-e1439160997647.jpg'); background-position-y: 44.8024%;">
			<img src="http://westernlake.ca/wp-content/uploads/2015/07/fried_prawn_spring_rolls.jpg-e1439160997647.jpg" alt="" style="display: none;">
		</div>
		<div class="container text-center">
			<div class="col-lg-8 push-lg-2">
				<h2 class="mb-3">Would you like to visit Us?</h2>
				<a href="/shop" class="btn btn-primary">
					<span>Order Online</span>
				</a>
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