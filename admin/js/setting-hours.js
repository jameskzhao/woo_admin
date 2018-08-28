$('input[type=radio][name=delivery_available]').change(function() {
    if (this.value == '1') {
        $('#delivery').show();
    } else if (this.value == '0') {
        $('#delivery').hide();
    }
});
$('input[type=radio][name=pickup_available]').change(function() {
    if (this.value == '1') {
        $('#pickup').show();
    } else if (this.value == '0') {
        $('#pickup').hide();
    }
});
$(document).ready(function() {
    var delivery_available = $('input[type=radio][name=delivery_available]:checked').val();
    var pickup_available = $('input[type=radio][name=pickup_available]:checked').val();
    if (delivery_available == 1) {
        $('#delivery').show();
    } else {
        $('#delivery').hide();
    }
    if (pickup_available == 1) {
        $('#pickup').show();
    } else {
        $('#pickup').hide();
    }
});
$("form").submit(function(event) {
    var post_data = $(this).serializeArray();
    event.preventDefault();
    $.post('server/save_hours.php', post_data, function(data) {
        $('#save-hours').append(
            '<p><div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">×</button><h4>Success!</h4>You have saved your hours settings.</div></p>'
        );
    }, 'json');
})