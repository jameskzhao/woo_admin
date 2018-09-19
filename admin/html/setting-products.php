<?php
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
                <div class="row">
                    <ul class="pager">
                        <li><a href="settings.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                        <li><a href="settings.php?page=<?php echo $page + 1; ?>">Next</a></li>
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
                        <li><a href="settings.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                        <li><a href="settings.php?page=<?php echo $page + 1; ?>">Next</a></li>
                    </ul>
                </div>
                <!-- /row -->
            