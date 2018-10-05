<?php
require_once 'auth-header.php';
require_once 'woo-header.php';
$page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;

try {
    $data = array(
        'per_page' => 20,
        'page' => $page,
    );
    $orders = $woocommerce->get('orders', $data);
    $orders_table_body = '';
    foreach ($orders as $single_order) {
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
    <?php header_libs('Admin - Archive');?>
    <link href="css/pages/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .daterangepicker .drp-calendar {
            display: none;
            max-width: 300px;
        }
    </style>
</head>

<body>
    <?php navbar_top('archive');?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-content">
                                <div class="col-lg-3">
                                        <input type="text" name="daterange" value="" />
                                </div>
                                <div class="col-lg-12">
                                    <canvas id="myChart" width="1000" height="400"></canvas>
                                </div>
                                <div class="col-lg-12">
                                    <ul class="pager">
                                        <li><a href="archive.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                                        <li><a href="archive.php?page=<?php echo $page + 1; ?>">Next</a></li>
                                    </ul>
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
                                    <ul class="pager">
                                        <li><a href="archive.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                                        <li><a href="archive.php?page=<?php echo $page + 1; ?>">Next</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                    <!-- /span12 -->
                </div>
                <!-- /row -->
                <div class="row">
                    
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- <script src="js/chart.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "alwaysShowCalendars": true,
                "startDate": "09/28/2018",
                "endDate": "10/04/2018"
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                var post_data = {start_date:start.format('YYYY-MM-DD'), end_date:end.format('YYYY-MM-DD')};
                $.post('server/wp_get_sales_report.php', post_data, function(data){
                    console.log(data.length);
                    var labels = [];
                    var new_data = [];
                    for(i = 0; i < data.length; i++){
                        labels.push(new Date(data[i].report_year, data[i].report_month-1, data[i].report_date).toLocaleString());
                        new_data.push({x: new Date(data[i].report_year, data[i].report_month-1, data[i].report_date),y: data[i].total_sales});
                    }
                    console.log(labels);
                    var ctx = document.getElementById("myChart").getContext("2d");
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                            label: 'Demo',
                            data: new_data,
                            borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                xAxes: [{
                                    type: 'time',
                                    distribution: 'series'
                                }],
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            elements: {
                                line: {
                                    tension: 0, // disables bezier curves
                                }
                            }
                    }
                    }); 
                },'json');
            });
        });
    </script>
    <script>
        
    </script>
</body>

</html>