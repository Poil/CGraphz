<?php
header("Content-type: text/javascript");

include('../modules/config.php');
?>

$(function(){
       	$('.multiselect').multiselect({
		locale: '<?php echo $WEB['def_lang'] ?>'
	});
});

$(document).ready(function() {
   $('.table_admin').dataTable( {
      "bStateSave": true,
      "oLanguage": {
         "sUrl": "lib/dataTables/locale/ui.dataTables-<?php echo $WEB['def_lang'] ?>.js"
      }
   });
});

function validate_del(form) {
    return confirm('<?php echo CONFIRM_DELETE ?>');
}

