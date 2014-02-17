<?php
header("Content-type: text/javascript");

include('../config/config.php');
?>

$(function(){
       	$('.multiselect').multiselect({
		locale: '<?php echo DEF_LANG ?>'
	});
});

$(document).ready(function() {
   $('.table_admin').dataTable( {
      "bStateSave": true,
      "oLanguage": {
         "sUrl": "lib/dataTables/locale/ui.dataTables-<?php echo DEF_LANG ?>.js"
      }
   });
});

function validate_del(form) {
    return confirm('<?php echo CONFIRM_DELETE ?>');
}

