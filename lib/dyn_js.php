<?php
header("Content-type: text/javascript");

include('../config/config.php');
?>

$(document).ready(function() {
        $('.table_admin').dataTable( {
                "bStateSave": true
        } );
} );

$(function(){
        $.localise('ui.multiselect', {language: '<?php echo DEF_LANG ?>',  path: 'lib/multiselect/locale/'});
        $(".multiselect").multiselect();
});
