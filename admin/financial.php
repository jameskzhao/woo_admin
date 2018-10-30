<?php
require_once 'auth-header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php header_libs('Admin - Financial');?>
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
    <?php navbar_top('financial');?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-content">
                                <h2>Sales Reports</h2>
                                <input type="text" name="sales_date_range" value="" />
                                <canvas id="myChart" style="width:100%; height:400px;"></canvas>
                            </div>
                            <!-- /widget-content -->
                        </div>
                        <!-- /widget -->
                    </div>
                    <!-- /span12 -->
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-content">
                                <h2>Top Sellers</h2>
                                <input type="text" name="top_seller_date_range" value="" />
                                <table id="top_seller_table" class="table table-striped table-bordered">
                                    <thead>
                                        <th> ID </th>
                                        <th> Name </th>
                                        <th> Quantity </th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
    <?php extra_bottom();?>
    <?php admin_page_footer();?>
    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
    <script>
        $(function() {
            var start = moment().subtract(6, 'days');
            var end = moment();
            var dr_options = {
                startDate: start, 
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "alwaysShowCalendars": true,
            };
            $('input[name="sales_date_range"]').daterangepicker(dr_options, get_sales_report);
            $('input[name="top_seller_date_range"]').daterangepicker(dr_options, get_top_seller_report);
            get_sales_report(start, end);
            get_top_seller_report(start, end);
            function get_top_seller_report(start, end){
                var post_data = {start_date:start.format('YYYY-MM-DD'), end_date:end.format('YYYY-MM-DD')};
                $.post('server/wp_get_top_seller_report.php', post_data, function(data){
                    $('#top_seller_table tbody').empty();
                    for(var i=0; i<data.length; i++){
                        var row = '<tr>' + 
                        '<td>' + data[i].product_id + '</td>' + 
                        '<td>' + data[i].name + '</td>' + 
                        '<td>' + data[i].quantity + '</td>' + 
                        '</tr>';
                        $('#top_seller_table tbody').append(row);
                    }
                    
                },'json');
            }
            function get_sales_report(start, end){
                var post_data = {start_date:start.format('YYYY-MM-DD'), end_date:end.format('YYYY-MM-DD')};
                $.post('server/wp_get_sales_report.php', post_data, function(data){
                    var totals = data.totals;
                    var labels = [];
                    var sales = [];
                    var orders = [];
                    for(var key in totals){
                        labels.push(key);
                        sales.push(totals[key].sales);
                        orders.push(totals[key].orders);
                    }
                    var ctx = document.getElementById("myChart").getContext("2d");
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Sales',
                                    data: sales,
                                    borderWidth: 1
                                },
                                {
                                    label: 'Orders',
                                    data: orders,
                                    borderWidth: 1
                                },
                            ]
                        },
                        options: {
                            scales: {
                                xAxes: [{
                                    distribution: 'linear'
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
            }
        });
    </script>
    
</body>

</html>