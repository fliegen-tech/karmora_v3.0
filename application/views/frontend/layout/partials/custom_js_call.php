<?php
if (!$this->session->userdata('front_data')) {?>
<script>
$(function () {
        $('#login_submit').click(function () {
            $.post(baseurl + 'login', $('#form-signin').serialize(), function (data, status) {
                alert(data);
                var parsedJson = jQuery.parseJSON(data);
                console.info(parsedJson.data+parsedJson.redirect);
                if (parsedJson.msg === "1") {
                        $('#sucessfully').html('<div class="error_msgs">Successfully Logged in</div>');
                        setTimeout(function () {
                            location.href = parsedJson.data+parsedJson.redirect;
                        }, 1000);
                    }
                    else if (parsedJson.msg === "0") {
                        $('#sucessfully').html('<div class="error_msgs">Incorrect Username OR Password</div>');
                    }
            });
        });
    });
</script>
<?php } ?>
<script>
    function signup(){
        var form = jQuery("#form");
        var data = form.serialize();
  	jQuery.ajax({
	   type: 'POST', 
           url: baseurl+'signup',
	   data:data,
	   form: form,
            context: document.body,
            error: function() {
            },
            success: function(data) { 
                var parsedJson = jQuery.parseJSON(data);
                if (parsedJson.msg === "1") {
                    $('.error_msg').html('Successfully Signed Up');
                } else {
                    $('.error_msg').html(parsedJson.data);
                }
                
            }
        });
    }
</script>