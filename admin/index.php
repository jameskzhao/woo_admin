<?php
require_once 'auth-header.php';
require_once 'woo-header.php';
$current_time_gmt = date(DateTime::ISO8601, current_time('timestamp', 1));
try {
    $orders = $woocommerce->get('orders');
    $orders_table_body = '';
    foreach($orders as $single_order){
        $name = $single_order->billing->first_name . ' ' . $single_order->billing->last_name;
        $orders_table_body .= '<tr>
        <td>' . $single_order->id . '</td>
        <td>' . $name . '</td>
        <td>' . $single_order->date_created . '</td>
        <td>' . $single_order->total . '</td>
        <td>' . $single_order->status . '</td>
        </tr>';
    }
} catch (HttpClientException $e) {
    $e->getMessage(); // Error message.
    $e->getRequest(); // Last request data.
    $e->getResponse(); // Last response data.
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php header_libs('Admin - Orders');?>
</head>

<body>
    <?php navbar_top('index');?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th> Time Created </th>
                                <th> Total </th>
                                <th> Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $orders_table_body; ?>
                        </tbody>
                    </table>

                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-inner -->
    </div>
    <!-- /main -->
    <?php extra_bottom();?>
    <?php admin_page_footer();?>
    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    
</body>

</html>