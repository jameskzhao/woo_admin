<?php
require_once 'auth-header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php header_libs('Settings');?>
    <link href="css/pages/dashboard.css" rel="stylesheet">
    
</head>

<body>
    <?php navbar_top('settings');?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
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
    
</body>

</html>