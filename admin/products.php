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

    $product_table_body = '';
    foreach ($products as $single_product) {
        $stock = $single_product->in_stock? 'In Stock':'Out of Stock';
        $product_table_body .= '<tr>
        <td>' . $single_product->id . '</td>
        <td>' . $single_product->name . '</td>
        <td>' . $stock . '</td>
        <td class="td-actions">
        <a href="javascript:;" id="edit-product_'.$single_product->id.'" class="edit-product btn btn-lg btn-primary"><i class="fas fa-edit"></i> Edit</a>
        </td>
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
                                            <th> Stock </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $product_table_body; ?>
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
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
        <div class="modal-body">
            <h3 id="modal-title"></h3>
            <div id="error_alert" class="alert" style="display:none;">

            </div>
            <hr>
            <form action="" id="edit-product">
                <fieldset>
                    <input id ="product_id" type="text" style="">
                </fieldset>
                <div id="product_detail"></div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            <button type="button" class="btn btn-primary"id="print_order"><i class="fas fa-upload"></i> Update</button>
            <!-- <button type="button" id="modal_save_btn" class="btn btn-primary">Save changes</button> -->
        </div>
    </div>
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
        $('.edit-product').click(function(){
                var product_id = this.id.replace('edit-product_','');
                var product = get_product_by_key(product_id);
                console.log(product);
                var table = '<table class="table table-bordered">';
                var display_fields = ['id', 'name', 'regular_price', 'in_stock'];
                for(key in product){
                    if(product.hasOwnProperty(key) && display_fields.indexOf(key)!=-1){
                        table += '<tr><td>'+key+'</td><td>'+product[key]+'</td></tr>';
                    }
                }
                table += '</table>';
                $('#product_detail').html(table);
                $('#modal-title').text('Product #:'+product_id);
                $('#product_id').attr('value', product_id);
                $('#productModal').modal();

            });
        function get_product_by_key(key_id){
            for(var i = 0; i < products.length; i++){
                if(products[i].id==key_id){
                    return products[i];
                }
            }
        }
    </script>
    
</body>