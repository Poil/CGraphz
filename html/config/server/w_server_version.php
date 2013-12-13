<?php
if (isset($_POST['f_submit_server_version'])) {

    $f_id_config_server=intval($_POST['f_id_config_server']);
    $f_server_version=intval($_POST['f_server_version']);
    $connSQL=new DB();

    if ($f_id_config_server) { // UPDATE
        $lib='
			UPDATE `config_server` SET
				`collectd_version`=:version
			WHERE
				`id_config_server`=:id';
        $stmt = $connSQL->prepare($lib);
        $stmt->bindParam(':id',$f_id_config_server);
        $stmt->bindParam(':version',$f_server_version);
        $stmt->execute();
    }
}
?>
