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
    <div class="extra">
        <div class="extra-inner">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <h4>
                            About Free Admin Template</h4>
                        <ul>
                            <li>
                                <a href="javascript:;">EGrappler.com</a>
                            </li>
                            <li>
                                <a href="javascript:;">Web Development Resources</a>
                            </li>
                            <li>
                                <a href="javascript:;">Responsive HTML5 Portfolio Templates</a>
                            </li>
                            <li>
                                <a href="javascript:;">Free Resources and Scripts</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Support</h4>
                        <ul>
                            <li>
                                <a href="javascript:;">Frequently Asked Questions</a>
                            </li>
                            <li>
                                <a href="javascript:;">Ask a Question</a>
                            </li>
                            <li>
                                <a href="javascript:;">Video Tutorial</a>
                            </li>
                            <li>
                                <a href="javascript:;">Feedback</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Something Legal</h4>
                        <ul>
                            <li>
                                <a href="javascript:;">Read License</a>
                            </li>
                            <li>
                                <a href="javascript:;">Terms of Use</a>
                            </li>
                            <li>
                                <a href="javascript:;">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Open Source jQuery Plugins</h4>
                        <ul>
                            <li>
                                <a href="">Open Source jQuery Plugins</a>
                            </li>
                            <li>
                                <a href="">HTML5 Responsive Tempaltes</a>
                            </li>
                            <li>
                                <a href="">Free Contact Form Plugin</a>
                            </li>
                            <li>
                                <a href="">Flat UI PSD</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /extra-inner -->
    </div>
    <!-- /extra -->
    <?php

}
function admin_page_footer()
{
    ?>
    <div class="footer">
        <div class="footer-inner">
            <div class="container">
                <div class="row">
                    <div class="span12"> &copy; 2013
                        <a href="#">Bootstrap Responsive Admin Template</a>. </div>
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