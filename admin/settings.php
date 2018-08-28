<?php
require_once 'auth-header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php header_libs('Admin - Settings'); ?>
    <link href="css/pages/settings.css" rel="stylesheet">
    
</head>

<body>
    <?php navbar_top('settings'); ?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#general" data-toggle="tab">General</a>
                            </li>
                            <li>
                                <a href="#hours" data-toggle="tab">Hours</a>
                            </li>
                            <li>
                                <a href="#products" data-toggle="tab">Products</a>
                            </li>
                            <li>
                                <a href="#promos" data-toggle="tab">Promos</a>
                            </li>
                            <li>
                                <a href="#text" data-toggle="tab">Text/SMS</a>
                            </li>
                        </ul>
                        <br>
                        <div class="tab-content">
                            <div class="tab-pane active" id="general">
                                general
                            </div>
                            <div class="tab-pane " id="hours">
                                <?php require_once('html/setting-hours.php');?>
                            </div>
                            <div class="tab-pane " id="products">
                                products
                            </div>
                            <div class="tab-pane " id="promos">
                                promos
                            </div>
                            <div class="tab-pane " id="text">
                                text
                            </div>
                        </div>
                    </div>
                    <!-- /tabbable -->
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
    <script src="js/setting-hours.js"></script>
    
</body>

</html>