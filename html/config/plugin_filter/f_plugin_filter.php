
<form name="f_form_plugin_filter" method="post" action="<?php echo removeqsvar($cur_url, 'f_id_config_plugin_filter'); ?>">
	<input type="hidden" name="f_id_config_plugin_filter" id="f_id_config_plugin_filter" value="<?php echo @$cur_plugin_filter->id_config_plugin_filter; ?>" />
	<label for="f_plugin_filter_desc">Description</label>
	<input type="text" name="f_plugin_filter_desc" id="f_plugin_filter_desc" value="<?php echo @$cur_plugin_filter->plugin_filter_desc; ?>" /><br />
	<label for="f_plugin_filter_p">Plugin</label>
	<input type="text" name="f_plugin_filter_p" id="f_plugin_filter_p" value="<?php echo @$cur_plugin_filter->plugin; ?>" />&nbsp;(regexp)<br />
	<label for="f_plugin_filter_pi">Plugin instance</label>
	<input type="text" name="f_plugin_filter_pi" id="f_plugin_filter_pi" value="<?php echo @$cur_plugin_filter->plugin_instance; ?>" />&nbsp;(regexp)<br />
	<label for="f_plugin_filter_t">Type</label>
	<input type="text" name="f_plugin_filter_t" id="f_plugin_filter_t" value="<?php echo @$cur_plugin_filter->type; ?>" />&nbsp;(regexp)<br />
	<label for="f_plugin_filter_ti">Type instance</label>
	<input type="text" name="f_plugin_filter_ti" id="f_plugin_filter_ti" value="<?php echo @$cur_plugin_filter->type_instance; ?>" />&nbsp;(regexp)<br />
	<label for="f_plugin_filter_plugin_order">Ordre d'affichage</label>
	<input type="text" name="f_plugin_filter_plugin_order" id="f_plugin_filter_plugin_order" value="<?php echo @$cur_plugin_filter->plugin_order; ?>" />&nbsp;(int)<br />
	<input type="submit" name="f_submit_plugin_filter" id="f_submit_plugin_filter" value="Envoyer" />
</form>


<form name="f_form_del_plugin_filter" method="post" action="">
	<input type="hidden" name="f_id_config_plugin_filter" id="f_del_id_config_plugin_filter" value="<?php echo $cur_plugin_filter->id_config_plugin_filter; ?>" />
	<input type="submit" name="f_del_plugin_filter" id="f_del_plugin_filter" value="Supprimer" />
</form>
