<?php
require_once 'auth-header.php';
require_once 'woo-header.php';

$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
$current_date_start = date('c', strtotime(current_time('Y-m-d 00:00:00')));
$current_date_end = date('c', strtotime(current_time('Y-m-d 00:00:00') . ' +1 day'));
$data = array(
    'per_page' => 20,
    'page' => $page,
    'after' => $current_date_start,
    'before' => $current_date_end,
);

try {
    $orders = $woocommerce->get('orders', $data);
    $orders_table_body = '';
    foreach ($orders as $single_order) {
        $name = $single_order->billing->first_name . ' ' . $single_order->billing->last_name;
        $order_type = get_post_meta($single_order->id, '_order_type', true);
        $tr_class = ($single_order->status == 'new') ? 'new-order-tr' : '';
        $orders_table_body .= '<tr class="' . $tr_class . '">
        <td id="td_order_id_' . $single_order->id . '">' . $single_order->id . '</td>
        <td id="td_order_type_' . $single_order->id . '">' . $order_type . '</td>
        <td>' . $name . '</td>
        <td id="td_order_date_' . $single_order->id . '">' . $single_order->date_created . '</td>
        <td id="td_order_total_' . $single_order->id . '">' . $single_order->total . '</td>
        <td id="td_order_status_' . $single_order->id . '">' . $single_order->status . '</td>
        <td class="td-actions">
            <a href="javascript:;" id="edit-order_' . $single_order->id . '"class="edit-order btn btn-lg btn-primary"><i class="fas fa-search"></i> View</a>
            <a href="javascript:;" id="complete-order_' . $single_order->id . '"class="complete-order btn btn-lg btn-success"><i class="fas fa-check"></i> Complete</a>
            <a href="javascript:;" id="delete-order_' . $single_order->id . '"class="del-order btn btn-lg btn-danger"><i class="far fa-trash-alt"></i> Cancel</a>
            
            
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
                                <div id="new-order" class="alert" style="display:none;">
                                    You have <span id="new-order-count"></span> new order(s)! Please <a href=".">refresh to view</a>.
                                </div>
                                <h1>Order List Today</h1>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th> ID </th>
                                            <th> Type </th>
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
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog">
        <div class="modal-body">
            <h3 id="modal-title"></h3>
            <div id="error_alert" class="alert" style="display:none;">

            </div>
            <hr>
            <form action="" id="edit-order">
                <fieldset>
                    <input id ="order_id" type="text" style="display:none;">
                </fieldset>
            </form>
            <div class="tabtable">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active"><a href="#bill" data-toggle="tab">Bill</a></li>
                    <li role="presentation"><a href="#order" data-toggle="tab">Order</a></li>
                    <li role="presentation"><a href="#remarks" data-toggle="tab">Remarks</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="bill">
                    </div>
                    <div class="tab-pane" id="order">
                    </div>
                    <div class="tab-pane" id="remarks">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            <button type="button" class="btn btn-primary"id="print_order"><i class="fas fa-print"></i> Print Order</button>
            <!-- <button type="button" id="modal_save_btn" class="btn btn-primary">Save changes</button> -->
        </div>
    </div>
    
    <?php extra_bottom();
?>
    <?php admin_page_footer();
?>
    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/printThis.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(document).ready(function(){
            var orders = <?php echo json_encode($orders); ?>;
            $('.edit-order').click(function(){
                var order_id = this.id.replace('edit-order_','');
                var order_data = get_order_by_key(order_id);
                console.log(order_data);
                var bill_table = '<table class="table table-bordered">';
                var display_fields = ['first_name', 'last_name', 'email', 'phone'];
                for(key in order_data.billing){
                    if(order_data.billing.hasOwnProperty(key) && display_fields.indexOf(key)!=-1){
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
                for(var i = 0; i < order_data.fee_lines.length; i++){
                    var current_fee_line = order_data.fee_lines[i];
                    order_table += '<tr><td></td><td></td><td>'+current_fee_line.name+'</td><td>'+current_fee_line.total+'</td></tr>';
                }
                order_table += '<tr><td></td><td></td><td>Tax</td><td>'+order_data.total_tax+'</td></tr>';
                order_table += '<tr><td></td><td></td><td>Total</td><td>'+order_data.total+'</td></tr>';
                var remarks_table = '<table class="table table-bordered">';
                remarks_table += '<tr><td>Customer Note</td><td>'+order_data.customer_note+'</td></tr>';
                var order_wish_time = get_meta_data(order_data.meta_data, '_order_wish_time');
                var order_type = get_meta_data(order_data.meta_data, '_order_type');
                if(order_wish_time){
                    remarks_table += '<tr><td>Wish Time</td><td>'+order_wish_time+'</td></tr>';
                }
                if(order_type){
                    remarks_table += '<tr><td>Order Type</td><td>'+order_type+'</td></tr>';
                }
                remarks_table += '</table>';
                $("input[name=status][value=" + order_data.status + "]").attr('checked', 'checked');
                $('#modal-title').text('Order #:'+order_id);
                $('#bill').html(bill_table);
                $('#order').html(order_table);
                $('#remarks').html(remarks_table);
                $('#order_id').attr('value', order_id);
                $('#orderModal').modal();

            });
            $('.del-order').click(function(){
                if(confirm('Cancel order?')){
                    var del_order_id = $(this).attr('id').replace('delete-order_', '');
                    var post_data = {};
                    post_data.id = del_order_id;
                    post_data.status = 'cancelled';
                    $.post('server/wp_update_order.php',post_data, function(data){
                        if(typeof(data.error)!=='undefined'){
                            alert(data.error);
                        }else{
                            $('#td_order_status_'+data.id).html(data.status);
                            $('#td_order_id_'+data.id).closest('tr').removeClass('new-order-tr');
                        }
                    },'json');
                }
            });
            $('.complete-order').click(function(){
                if(confirm('Order Complete?')){
                    var complete_order_id = $(this).attr('id').replace('complete-order_', '');
                    var post_data = {};
                    post_data.id = complete_order_id;
                    post_data.status = 'completed';
                    $.post('server/wp_update_order.php',post_data, function(data){
                        console.log(data);
                        if(typeof(data.error)!=='undefined'){
                            alert(data.error);
                        }else{
                            $('#td_order_status_'+data.id).html(data.status);
                            $('#td_order_id_'+data.id).closest('tr').removeClass('new-order-tr');
                        }
                    },'json');
                }
            })
            $('#print_order').click(function(){
                var cur_order_id = $('#order_id').val();
                var post_data = {};
                post_data.id = cur_order_id;
                post_data.status = 'kitchen';
                $.post('server/wp_update_order.php',post_data, function(data){
                    if(typeof(data.error)!=='undefined'){
                        alert(data.error);
                    }else{
                        $('#td_order_status_'+data.id).html(data.status);
                        $('#td_order_id_'+data.id).closest('tr').removeClass('new-order-tr');
                        $('#orderModal').modal('toggle');
                        $("#order").printThis({
                            importCSS: false,
                            loadCSS: "",
                            header: "<h1>Order Print: " + cur_order_id + "</h1>"
                        });
                    }
                },'json');
            });

            function get_order_by_key(key_id){
                for(var i = 0; i < orders.length; i++){
                    if(orders[i].id==key_id){
                        return orders[i];
                    }
                }
            }
            function get_meta_data(meta_data, meta_name){
                for(var i = 0; i < meta_data.length; i++){
                    if(meta_data[i].key==meta_name){
                        return meta_data[i].value;
                    }
                }
            }
            var audio = new Audio('audio/alert.mp3');
            setInterval(
                function check_new_order(){
                    console.log('checking new orders');
                    if(orders.length>0){
                        var max_order_id = orders[0].id;
                    }else{
                        var max_order_id = 0;
                    }
                    $.post('server/check_new_order.php',{max_order_id:max_order_id}, function(data){
                        if(data.error_code==0){
                            console.log(data);
                            if(data.new_order_count > 0){
                                audio.play();
                                $('#new-order-count').text(data.new_order_count);
                                $('#new-order').show();
                            }else{
                                $('#new-order').hide();
                            }
                        }
                    },'json');
                },
                10000
            );

        });


    </script>
</body>
</html>