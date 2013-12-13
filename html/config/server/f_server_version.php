<form name="f_form_server_version" method="post" action="">
    <input type="hidden" name="f_id_config_server" id="f_id_config_server" value="<?php echo @$cur_server->id_config_server; ?>" />

        <label for="f_server_version"><?php echo COLLECTD_VERSION;?></label>
        <select name="f_server_version" id="f_server_version">
            <?php
            for ($i=3; $i<=5; $i++) {
                echo '<option value="'.$i.'"';
                if($i == $cur_server->collectd_version)
                {
                    echo ' selected="selected"';
                }
                echo '>';
                echo $i;
                echo '</option>';
            }
            ?>
        </select><br /><br />
    <input type="submit" name="f_submit_server_version" id="f_submit_server_version" value="<?php echo SUBMIT ?>" />
</form>