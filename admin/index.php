<?php
require_once 'auth-header.php';
require_once 'woo-header.php';

$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
$data = array(
    'per_page' => 20,
    'page' => $page,
    'status' => 'processing',
);

try {
    $orders = $woocommerce->get('orders', $data);
    $data['status'] = 'kitchen';
    $orders = array_merge($orders, $woocommerce->get('orders', $data));
    $orders_table_body = '';
    foreach ($orders as $single_order) {
        $name = $single_order->billing->first_name . ' ' . $single_order->billing->last_name;
        $orders_table_body .= '<tr>
        <td>' . $single_order->id . '</td>
        <td>' . $name . '</td>
        <td>' . $single_order->date_created . '</td>
        <td>' . $single_order->total . '</td>
        <td>' . $single_order->status . '</td>
        <td class="td-actions"><a href="javascript:;" id="edit-order_' . $single_order->id . '"class="edit-order btn btn-small btn-success"><i class="fas fa-edit"></i></a></td>
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
    <?php header_libs('Admin - Orders'); ?>
</head>

<body>
    <?php navbar_top('index'); ?>
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
                                <th></th>
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
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog">
        <div class="modal-body">
            <h3 id="modal-title"></h3>
            <hr>
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#bill" data-toggle="tab">Bill</a></li>
                <li role="presentation"><a href="#order" data-toggle="tab">Order</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="bill">
                </div>
                <div class="tab-pane" id="order">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
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

        $(document).ready(function(){
            var orders = <?php echo json_encode($orders); ?>;
            $('.edit-order').click(function(){
                var order_id = this.id.replace('edit-order_','');
                var order_data = get_order_by_key(order_id);
                console.log(order_data);
                $('#modal-title').text('Order #:'+order_id);
                $('#bill').html(order_data.billing.toString());
                $('#order').html(order_data.line_items.toString());
                $('#orderModal').modal();
            });
            function get_order_by_key(key_id){
                for(var i = 0; i < orders.length; i++){
                    if(orders[i].id=key_id){
                        return orders[i];
                    }
                }
            }
        });
        

    </script>
    
</body>

</html>