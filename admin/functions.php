<?php
function header_libs($title)
{
    ?>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <?php
}
function navbar_top($active_page = 'index')
{
    global $user;
    ?>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="index.php">Admin </a>
                <div class="nav-collapse">
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo $user->display_name; ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:;">Profile</a>
                                </li>
                                <li>
                                    <a href="/admin/login.php?logout=true">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
            <!-- /container -->
        </div>
        <!-- /navbar-inner -->
    </div>
    <!-- /navbar -->
    <div class="subnavbar">
        <div class="subnavbar-inner">
            <div class="container">
                <ul class="mainnav">
                    <li <?php echo $active_page == 'index' ? 'class="active"' : ''; ?>>
                        <a href="index.php">
                            <i class="fas fa-utensils"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li <?php echo $active_page == 'customers' ? 'class="active"' : ''; ?>>
                        <a href="customers.php">
                            <i class="fas fa-users"></i>
                            <span>Customers</span>
                        </a>
                    </li>
                    <li <?php echo $active_page == 'products' ? 'class="active"' : ''; ?>>
                        <a href="products.php">
                            <i class="fas fa-coffee"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    
                    <li <?php echo $active_page == 'archive' ? 'class="active"' : ''; ?>>
                        <a href="archive.php">
                            <i class="fas fa-archive"></i>
                            <span>Archive</span>
                        </a>
                    </li>
                    <li <?php echo $active_page == 'financial' ? 'class="active"' : ''; ?>>
                        <a href="financial.php">
                            <i class="fas fa-hand-holding-usd"></i>
                            <span>Financial</span>
                        </a>
                    </li>
                    <li <?php echo $active_page == 'settings' ? 'class="active"' : ''; ?>>
                        <a href="settings.php">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li <?php echo $active_page == 'emergency' ? 'class="active"' : ''; ?>>
                        <a href="emergency.php">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Emergency Brake</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /container -->
        </div>
        <!-- /subnavbar-inner -->
    </div>
    <!-- /subnavbar -->
    <?php

}

function extra_bottom()
{
    ?>
    
    <?php

}
function admin_page_footer()
{
    ?>
    <div class="footer">
        <div class="footer-inner">
            <div class="container">
                <div class="row">
                    <div class="span12"> &copy; <?php echo date('Y');?>
                        <a href="#">Dev Restaurant</a>. </div>
                    <!-- /span12 -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /footer-inner -->
    </div>
    <!-- /footer -->
    <?php

}
function get_setting($column){
    global $wpdb;
    $query = "SELECT $column FROM store_settings WHERE id = 1";
    if($query_result = $wpdb->get_results($query)){
        return $query_result[0];
    }
}