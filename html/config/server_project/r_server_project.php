<?php
if (isset($_GET['f_id_config_server'])) {
        $f_id_config_server=intval($_GET['f_id_config_server']);
               
        $connSQL=new DB();
        $lib='SELECT
                        csp.id_config_project,
                        csp.id_config_server,
                        cp.`project`,
						cp.`project_description`,
                        cs.`server_name`,
                        cs.server_description
                FROM
                        config_server_project csp
                                LEFT JOIN config_project cp
                                        ON csp.id_config_project=cp.id_config_project
                                LEFT JOIN config_server cs
                                        ON csp.id_config_server=cs.id_config_server
                WHERE csp.id_config_server="'.$f_id_config_server.'"';

        $all_server_project=$connSQL->getResults($lib);
        $cpt_server_project=count($all_server_project);
       
       
        $lib='SELECT
                        *
                FROM
                        config_project
                WHERE
                        id_config_project NOT IN (
                                SELECT id_config_project
                                FROM config_server_project
                                WHERE id_config_server="'.$f_id_config_server.'"
                        )
                ORDER BY
                        `project_description`';
       
        $connSQL=new DB();
        $all_project=$connSQL->getResults($lib);
        $cpt_project=count($all_project);
}
?>