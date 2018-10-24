<?php
require_once 'auth-header.php';
require_once 'woo-header.php';
$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
try {
    $data = array(
        'per_page' => 20,
        'page' => $page,
    );
    $products = $woocommerce->get('products', $data);

    $customer_table_body = '';
    foreach ($products as $single_product) {
        
        $customer_table_body .= '<tr>
        <td>' . $single_product->id . '</td>
        <td>' . $single_product->name . '</td>
        <td>' . $single_product->description . '</td>
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
    <?php header_libs('Admin - Products'); ?>
    <link href="css/pages/dashboard.css" rel="stylesheet">
    
</head>

<body>
    <?php navbar_top('products'); ?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-content">
                                <ul class="pager">
                                    <li><a href="products.php?page=<?php echo $page-1;?>">Previous</a></li>
                                    <li><a href="products.php?page=<?php echo $page+1;?>">Next</a></li>
                                </ul>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th> ID </th>
                                            <th> Name </th>
                                            <th> Description </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $customer_table_body; ?>
                                    </tbody>
                                </table>
                                <ul class="pager">
                                    <li><a href="products.php?page=<?php echo $page-1;?>">Previous</a></li>
                                    <li><a href="products.php?page=<?php echo $page+1;?>">Next</a></li>
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
    <script>
        var products = <?php echo json_encode($products);?>;
        console.log(products);
    </script>
    
</body>