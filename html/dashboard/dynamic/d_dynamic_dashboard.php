<?php
for ($i=0; $i<$cpt_dd; $i++) {
	echo '<li><a href="index.php?module=dashboard&amp;component=dynamic&amp;f_id_config_dynamic_dashboard='.$all_dd[$i]->id_config_dynamic_dashboard.'">'.$all_dd[$i]->title.'</a></li>';
}
?>