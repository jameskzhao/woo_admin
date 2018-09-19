<?php
$weekdays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$delivery = get_setting('delivery')->delivery;
$pickup = get_setting('pickup')->pickup;

function find_hours_of_weekday($hours_array, $weekday)
{

    foreach ($hours_array as $weekday_hous_obj) {
        if ($weekday_hous_obj->weekday == $weekday) {
            return $weekday_hous_obj;
        }
    }
}
function get_store_hours($type)
{
    global $wpdb;
    $query = "SELECT weekday, open, HOUR(start_hour) AS open_from_hr, MINUTE(start_hour) AS open_from_min, HOUR(end_hour) AS open_till_hr, MINUTE(end_hour) AS open_till_min, HOUR(close_start_hour) AS close_from_hr, MINUTE(close_start_hour) AS close_from_min, HOUR(close_end_hour) AS close_till_hr, MINUTE(close_end_hour) AS close_till_min FROM store_time WHERE type = '$type'";
    return $wpdb->get_results($query);
}
function hours_table_html($type = 'delivery')
{
    global $weekdays;
    $hours_array = get_hours($type);
    ?>
    <table class="table" id="<?php echo $type; ?>">
    <tr>
        <th>Day</th>
        <th>Open</th>
        <th>From</th>
        <th>Till</th>
    </tr>
    <?php 
    $cur_week_day = 1;
    foreach ($weekdays as $day_of_week) {
        $hours = find_hours_of_weekday($hours_array, $cur_week_day);

        ?>
        <tr>
            <td><?php echo $day_of_week; ?></td>
            <td>
                <select name="<?php echo $type . '_open[' . $cur_week_day . ']'; ?>">
                    <option value="1" <?php echo $hours->open == 'Y' ? 'selected="selected"' : ''; ?>>Yes</option>
                    <option value="0" <?php echo $hours->open == 'N' ? 'selected="selected"' : ''; ?>>No</option>
                </select>
            </td>
            <td>
                <select name="<?php echo $type . '_open_from_hr[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 24; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->open_from_hr ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
                :
                <select name="<?php echo $type . '_open_from_min[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 60; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->open_from_min ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
            </td>
            <td>
                <select name="<?php echo $type . '_open_till_hr[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 24; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->open_till_hr ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
                :
                <select name="<?php echo $type . '_open_till_min[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 60; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->open_till_min ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Closed</td>
            <td>
                <select name="<?php echo $type . '_close_from_hr[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 24; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->close_from_hr ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
                :
                <select name="<?php echo $type . '_close_from_min[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 60; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->close_from_min ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
            </td>
            <td>
                <select name="<?php echo $type . '_close_till_hr[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 24; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->close_till_hr ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
                :
                <select name="<?php echo $type . '_close_till_min[' . $cur_week_day . ']'; ?>">
                    <?php for ($i = 0; $i < 60; $i++) {
                        echo '<option value = "' . $i . '"' . ($i == $hours->close_till_min ? 'selected="selected"' : '') . '>' . $i . '</option>';
                    } ?>
                </select>
            </td>
        </tr>
        <?php
        $cur_week_day++;
    }
    ?>
</table>
<?php

}
?>

<form action="server/save_hours.php" method="post" class="form-horizontal">
    <div class="row">
        <div class="span6">
            <div class="widget">
                <div class="widget-header">
                    <h3>Delivery</h3>
                </div>
                <div class="widget-content">
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Delivery</label>
                                <div class="controls">
                                    <label class="radio inline">
                                        <input type="radio" name="delivery_available" value="1" <?php echo $delivery == 'Y' ? 'checked="checked"' : ''; ?>> Yes
                                    </label>
                                    <label class="radio inline">
                                        <input type="radio" name="delivery_available" value="0" <?php echo $delivery == 'N' ? 'checked="checked"' : ''; ?>> No
                                    </label>
                                </div>
                                <!-- /controls -->
                                
                            </div>
                            <!-- /control-group -->
                            <div>
                                <h2>Hours</h2>
                                <?php hours_table_html('delivery'); ?>
                            </div>
                        </fieldset>
                        
                    
                </div>
                <!-- widget-content -->
            </div>
        </div>
        <!-- span6 -->
        <div class="span6">
            <div class="widget">
                <div class="widget-header">
                    <h3>Pickup</h3>
                </div>
                <div class="widget-content">
                    <form action="server/save_pickup_hours.php" method="post" class="form-horizontal">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Pickup</label>
                                <div class="controls">
                                    <label class="radio inline">
                                        <input type="radio" name="pickup_available" value="1" <?php echo $pickup == 'Y' ? 'checked="checked"' : ''; ?>> Yes
                                    </label>
                                    <label class="radio inline">
                                        <input type="radio" name="pickup_available" value="0" <?php echo $pickup == 'N' ? 'checked="checked"' : ''; ?>> No
                                    </label>
                                </div>
                                <!-- /controls -->
                            </div>
                            <!-- /control-group -->
                            <div>
                                <h2>Hours</h2>
                                <?php hours_table_html('pickup'); ?>
                            </div>
                        </fieldset>
                    
                </div>
            </div>
        </div>
        
    </div>
    <div class="row" >
        <div class="span12">
            <div class="widget">
                <div class="widget-content text-center" id = "save-hours">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-danger" onClick="window.location.reload()">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
