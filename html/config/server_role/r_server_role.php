<?php
if (isset($_GET['f_id_config_server'])) {
        $f_id_config_server=intval($_GET['f_id_config_server']);
               
        $connSQL=new DB();
        $lib='SELECT
                        crs.id_config_role,
                        crs.id_config_server,
                        cr.`role`,
						cr.`role_description`,
                        cs.`server_name`,
                        cs.server_description
                FROM
                        config_role_server crs
                                LEFT JOIN config_role cr
                                        ON crs.id_config_role=cr.id_config_role
                                LEFT JOIN config_server cs
                                        ON crs.id_config_server=cs.id_config_server
                WHERE crs.id_config_server="'.$f_id_config_server.'"';

        $all_server_role=$connSQL->getResults($lib);
        $cpt_server_role=count($all_server_role);
       
       
        $lib='SELECT
                        *
                FROM
                        config_role
                WHERE
                        id_config_role NOT IN (
                                SELECT id_config_role
                                FROM config_role_server
                                WHERE id_config_server="'.$f_id_config_server.'"
                        )
                ORDER BY
                        `role_description`';
       
        $connSQL=new DB();
        $all_role=$connSQL->getResults($lib);
        $cpt_role=count($all_role);
}
?>