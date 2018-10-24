<?php
require_once 'auth-header.php';

$emergency_settings = get_emergency_settings();
function get_emergency_settings()
{
    global $wpdb;
    $query = "SELECT emergency, emergency_expire FROM store_settings WHERE id = 1";
    return $wpdb->get_results($query)[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php header_libs('Admin - Emergency Brake'); ?>
    <link href="css/pages/dashboard.css" rel="stylesheet">
    <style>
        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        .switch input {
        opacity: 0;
        width: 0;
        height: 0;
        }

        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
    </style>
</head>






<body>
    <?php navbar_top('emergency'); ?>
    <div class="main">
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-content">
                                <p>
                                    <h2>Switch toggle to enable/disable emergency brake:</h2>
                                </p>
                                
                                <p>
                                    <form id="emergency_form" action="" method="post">
                                        <div class="row">
                                            <div class="span2">
                                                <label class="switch">
                                                    <input type="checkbox" id="emergency_switch" name="emergency_status" value="Yes">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="span9">
                                                <table id="expiration_table">
                                                    <tr>
                                                        <td><label class="radio"><input type="radio" value="manual" name="expiration">Untill manually turn off</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="radio"><input type="radio" value="auto" name="expiration">Untill specified time</label></td>
                                                        <td><input type="datetime-local" name="expiration_time" id="expiration_time"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /row -->
                                        <button class="btn btn-large btn-primary" type="submit">Save change</button>
                                    </form>
                                </p>
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
    <?php extra_bottom(); ?>
    <?php admin_page_footer(); ?>
    <!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(document).ready(function(){
            var emergency_settings = <?php echo json_encode($emergency_settings); ?>;
            var exp_datetime = '<?php echo str_replace(' ', 'T', date('Y-m-d h:i', strtotime($emergency_settings->emergency_expire))); ?>';
            if(emergency_settings.emergency!=='N'){
                $('#emergency_switch').prop('checked', true); 
                if(emergency_settings.emergency=='E'){
                    $('input[type="radio"][name="expiration"][value="auto"]').prop('checked', true);
                    $('#expiration_time').val(exp_datetime);
                }else{
                    $('input[type="radio"][name="expiration"][value="manual"]').prop('checked', true);
                }
            }else{
                $('#emergency_switch').prop('checked', false); 
                $('#expiration_table').hide();
            }
        });        
        $('#emergency_switch').change(function(){
            var is_checked = $(this).is(':checked');
            if(is_checked){
                $('#expiration_table').show();
            }else{
                $('#expiration_table').hide();
            }
        });


        $( "#emergency_form" ).submit(function( event ) {
            event.preventDefault();
            var post_data = {};
            var expiration = $('input[type="radio"][name="expiration"]:checked').val();
            var exp_time = $('#expiration_time').val();
            
            
            post_data.status = $('#emergency_switch').is(':checked')?(expiration=='manual'?'Y':'E'):'N';
            if(post_data.status!=='N'){
                if(typeof(expiration)=='undefined'){
                    alert('Please choose expiration type');
                }else if(expiration=='auto'&&exp_time.length==0){
                    alert('Please specify expiration date and time');
                }
            }
            
            post_data.exp_time = exp_time;
            $.post('server/save_emergency.php', post_data, function(data){
                if(data.error_code>0){
                    alert(data.error_message);
                }else{
                    alert('Update successful.')
                }
            }, 'json');
            console.log(post_data);
        });
    </script>

</body>

</html>