<?php
require_once 'auth-header.php';
require_once 'woo-header.php';
$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
try {
    $data = array(
        'per_page' => 20,
        'page' => $page,
    );
    $customers = $woocommerce->get('customers', $data);

    $customer_table_body = '';
    foreach ($customers as $single_customer) {
        $name = !empty($single_customer->billing->first_name) ? $single_customer->billing->first_name . ' ' . $single_customer->billing->last_name : $single_customer->username;
        $customer_table_body .= '<tr>
        <td>' . $single_customer->id . '</td>
        <td><img src="' . $single_customer->avatar_url . '" style="max-width:26px;"></td>
        <td>' . $name . '</td>
        <td>' . $single_customer->billing->address_1 . '</td>
        <td>' . $single_customer->billing->postcode . '</td>
        <td>' . $single_customer->billing->city . '</td>
        <td>' . $single_customer->billing->phone . '</td>
        <td>' . $single_customer->email . '</td>
        <td>' . $single_customer->orders_count . '</td>
        <td>' . $single_customer->total_spent . '</td>
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
    <?php header_libs('Admin - Customers'); ?>
    <link href="css/pages/dashboard.css" rel="stylesheet">
    
</head>

<body>
    <?php navbar_top('customers'); ?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-content">
                                <ul class="pager">
                                    <li><a href="customers.php?page=<?php echo $page-1;?>">Previous</a></li>
                                    <li><a href="customers.php?page=<?php echo $page+1;?>">Next</a></li>
                                </ul>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th> ID </th>
                                            <th> Avatar </th>
                                            <th> Name </th>
                                            <th> Street </th>
                                            <th> Postal Code </th>
                                            <th> City </th>
                                            <th> Phone </th>
                                            <th> Email </th>
                                            <th> Orders </th>
                                            <th> Total Spent </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $customer_table_body; ?>
                                    </tbody>
                                </table>
                                <ul class="pager">
                                    <li><a href="customers.php?page=<?php echo $page-1;?>">Previous</a></li>
                                    <li><a href="customers.php?page=<?php echo $page+1;?>">Next</a></li>
                                </ul>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                    <!-- /span12 -->
                    
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /main-inner -->
    </div>
    <!-- /main -->
    <?php extra_bottom(); ?>
    <?php admin_page_footer(); ?>
    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    
</body>

</html>