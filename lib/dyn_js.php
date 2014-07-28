<?php
header("Content-type: text/javascript");

include('../config/config.php');

?>

$(document).ready(function() {
   $('.table_admin').dataTable( {
      "bStateSave": true,
      "oLanguage": {
         "sUrl": "lib/dataTables/locale/ui.dataTables-<?php echo DEF_LANG ?>.js"
      }
   });
   $('.table_admin').addClass('table table-striped table-bordered table-hover table-condensed table-striped');

});

function validate_del(form) {
    return confirm('<?php echo CONFIRM_DELETE ?>');
}

$(function(){
    $('.multiselect').multiselect({
        locale: '<?php echo DEF_LANG ?>'
    });
});

