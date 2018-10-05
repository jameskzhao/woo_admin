<?php
require_once 'auth-header.php';
require_once 'woo-header.php';

$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
$data = array(
    'per_page' => 20,
    'page' => $page,

);

try {
    $orders = $woocommerce->get('orders', $data);
    $orders_table_body = '';
    foreach ($orders as $single_order) {
        $name = $single_order->billing->first_name . ' ' . $single_order->billing->last_name;
        $orders_table_body .= '<tr>
        <td id="td_order_id_' . $single_order->id . '">' . $single_order->id . '</td>
        <td>' . $name . '</td>
        <td id="td_order_date_' . $single_order->id . '">' . $single_order->date_created . '</td>
        <td id="td_order_total_' . $single_order->id . '">' . $single_order->total . '</td>
        <td id="td_order_status_' . $single_order->id . '">' . $single_order->status . '</td>
        <td class="td-actions">
            <a href="javascript:;" id="edit-order_' . $single_order->id . '"class="edit-order btn btn-small btn-primary"><i class="fas fa-edit"></i></a>
            <a href="javascript:;" id="delete-order_' . $single_order->id . '"class="del-order btn btn-small btn-danger"><i class="far fa-trash-alt"></i></a>
        </td>
        </tr>';
    }
} catch (Automattic\WooCommerce\HttpClient\HttpClientException $e) {
    $e->getMessage();
    //     Error message.
    $e->getRequest();
    //     Last request data.
    $e->getResponse();
    //     Last response data.
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php header_libs('Admin - Orders');
?>
</head>
<body>
    <?php navbar_top('index');
?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-content">
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
                                        <?php echo $orders_table_body;?>
                                    </tbody>
                                </table>
                            </div>
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
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog">
        <div class="modal-body">
            <h3 id="modal-title"></h3>
            <div id="error_alert" class="alert" style="display:none;">

            </div>
            <hr>
            <form action="" id="edit-order">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label">Change Status</label>
                        <div class="controls">
                            <label class="radio inline">
                                <input type="radio" name="status" value="new"> New
                            </label>
                            <label class="radio inline">
                                <input type="radio" name="status" value="kitchen"> Kitchen
                            </label>
                            <label class="radio inline">
                                <input type="radio" name="status" value="ready"> Ready
                            </label>
                            <label class="radio inline">
                                <input type="radio" name="status" value="pickup"> Picked Up
                            </label>

                        </div>
                        <!-- /controls -->
                    </div>
                    <input id ="order_id" type="text" style="display:none;">
                </fieldset>
            </form>
            <div class="tabtable">
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
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="modal_save_btn" class="btn btn-primary">Save changes</button>
        </div>
    </div>
    <!-- /main -->
    <?php extra_bottom();
?>
    <?php admin_page_footer();
?>
    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(document).ready(function(){
            var orders = <?php echo json_encode($orders);
?>;
            $('.edit-order').click(function(){
                var order_id = this.id.replace('edit-order_','');
                var order_data = get_order_by_key(order_id);
                console.log(order_data);
                var bill_table = '<table class="table table-bordered">';
                for(key in order_data.billing){
                    if(order_data.billing.hasOwnProperty(key)){
                        bill_table += '<tr><td>'+key+'</td><td>'+order_data.billing[key]+'</td></tr>';
                    }
                }
                bill_table += '</table>';
                var order_table = '<table class="table table-bordered">';
                order_table += '<thead><tr><th>Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr></thead>'
                for(var i = 0; i < order_data.line_items.length; i++){
                    var current_product = order_data.line_items[i];
                    order_table += '<tr><td>'+current_product.name+'</td><td>'+current_product.price+'</td><td>'+current_product.quantity+'</td><td>'+current_product.total+'</td></tr>';
                }
                order_table += '<tr><td></td><td></td><td>Tax</td><td>'+order_data.total_tax+'</td></tr>';
                order_table += '<tr><td></td><td></td><td>Total</td><td>'+order_data.total+'</td></tr>';
                $("input[name=status][value=" + order_data.status + "]").attr('checked', 'checked');
                $('#modal-title').text('Order #:'+order_id);
                $('#bill').html(bill_table);
                $('#order').html(order_table);
                $('#order_id').attr('value', order_id);
                $('#orderModal').modal();

            });
            $('#modal_save_btn').click(function(){
                var cur_order_id = $('#order_id').val();
                var cur_order_status = $("input[name='status']:checked").val();
                if (typeof cur_order_status != 'undefined'){
                    var post_data = {};
                    post_data.id = cur_order_id;
                    post_data.status = cur_order_status;
                    $.post('server/wp_update_order.php',post_data, function(data){
                        if(typeof(data.error)!=='undefined'){
                            alert(data.error);
                        }else{
                            $('#td_order_status_'+data.id).html(data.status);
                        }
                    },'json');
                    $('#orderModal').modal('toggle');
                }else{
                    $('#error_alert').html('<strong>Error!</strong> No Status has been selected.');
                    $('#error_alert').show();

                }
            });
            function get_order_by_key(key_id){
                for(var i = 0; i < orders.length; i++){
                    if(orders[i].id==key_id){
                        return orders[i];
                    }
                }
            }
        });
    </script>
</body>
</html>