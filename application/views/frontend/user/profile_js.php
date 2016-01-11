
<script>
    $(document).ready(function () {
            $('#uncheck').click(function (event) {
                if (this.checked) {
                    $('.check').each(function () {
                        this.checked = false;
                    });
                }
                else {
                    $('.check').each(function () {
                        this.checked = true;
                    });
                }
                $('#uncheck').checked = true;
            });
        });
</script>
<script src="<?php echo $themeUrl ?>/js/js_upload/jquery.knob.js"></script> 
<script type="text/javascript" src="<?php echo $themeUrl ?>/js/js_upload/jquery.ui.widget.js"></script> 
<script type="text/javascript" src="<?php echo $themeUrl ?>/js/js_upload/jquery.iframe-transport.js"></script> 
<script type="text/javascript" src="<?php echo $themeUrl ?>/js/js_upload/jquery.fileupload.js"></script> 
<script type="text/javascript" src="<?php echo $themeUrl ?>/js/js_upload/script.js"></script> 