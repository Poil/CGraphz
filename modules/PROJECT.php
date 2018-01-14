<?php
class PROJECT {
    private $id_config_project;

    function __construct($id_config_project) {
        $this->connSQL=new DB();

        // Need to improve that a day
        $this->id_auth_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);
        $this->id_config_project=filter_var($id_config_project,FILTER_SANITIZE_NUMBER_INT);
    }

    function get_servers($id_config_environment=null, $id_config_role=null) {
        if (!empty($id_config_environment)) {
            $JOIN_ENV='LEFT OUTER JOIN config_environment_server ces
                    ON cs.id_config_server=ces.id_config_server';
            $WHERE_ENV='AND ces.id_config_environment=:id_config_environment';
            $this->connSQL->bind('id_config_environment',$id_config_environment);
        } else {
            $JOIN_ENV='';
            $WHERE_ENV='';
        }
        if (!empty($id_config_role)) {
            $JOIN_ROLE='LEFT OUTER JOIN config_role_server crs
                    ON cs.id_config_server=crs.id_config_server';
            $WHERE_ROLE='AND crs.id_config_role=:id_config_role';
            $this->connSQL->bind('id_config_role',$id_config_role);
        } else {
            $JOIN_ROLE='';
            $WHERE_ROLE='';
        }

        $lib='
        SELECT cs.*
        FROM config_server cs
        LEFT JOIN config_server_project csp
            ON cs.id_config_server=csp.id_config_server
        LEFT JOIN perm_project_group ppg
            ON ppg.id_config_project=csp.id_config_project
        LEFT JOIN auth_group ag
            ON ag.id_auth_group=ppg.id_auth_group
        LEFT JOIN auth_user_group aug
            ON aug.id_auth_group=ag.id_auth_group
        '.$JOIN_ENV.'
        '.$JOIN_ROLE.'
        WHERE  csp.id_config_project=:id_config_project
            AND aug.id_auth_user=:id_auth_user
            '.$WHERE_ENV.'
            '.$WHERE_ROLE.'
        ORDER BY cs.server_name';

        $this->connSQL->bind('id_config_project',$this->id_config_project);
        $this->connSQL->bind('id_auth_user',$this->id_auth_user);

        return $this->connSQL->query($lib);
    }

    function get_servers_roles($id_config_environment=null) {
        if (!empty($id_config_environment)) {
            $JOIN_ENV='LEFT OUTER JOIN config_environment_server ces
                    ON cs.id_config_server=ces.id_config_server';
            $WHERE_ENV='AND ces.id_config_environment=:id_config_environment';
            $this->connSQL->bind('id_config_environment',$id_config_environment);
        } else {
            $JOIN_ENV='';
            $WHERE_ENV='';
        }
        $lib='
        SELECT
            cr.id_config_role,
            CASE
                WHEN cr.role_description IS NULL THEN "'.OTHERS.'"
            ELSE cr.role_description
            END AS role_description
        FROM config_server cs
        LEFT OUTER JOIN config_role_server crs
            ON cs.id_config_server=crs.id_config_server
        LEFT OUTER JOIN config_role cr
            ON crs.id_config_role=cr.id_config_role
        '.$JOIN_ENV.'
        LEFT JOIN config_server_project csp
            ON cs.id_config_server=csp.id_config_server
        LEFT JOIN perm_project_group ppg
            ON ppg.id_config_project=csp.id_config_project
        LEFT JOIN auth_group ag
            ON ag.id_auth_group=ppg.id_auth_group
        LEFT JOIN auth_user_group aug
            ON aug.id_auth_group=ag.id_auth_group
        WHERE  csp.id_config_project=:id_config_project
            AND aug.id_auth_user=:id_auth_user
            '.$WHERE_ENV.'
        GROUP BY id_config_role, role_description
        ORDER BY role_description';

        $this->connSQL->bind('id_config_project',$this->id_config_project);
        $this->connSQL->bind('id_auth_user',$this->id_auth_user);

        return $this->connSQL->query($lib);
    }
    function get_servers_environments($id_config_role=null) {
        if (!empty($id_config_role)) {
            $JOIN_ROLE='LEFT OUTER JOIN config_role_server crs
                    ON cs.id_config_server=crs.id_config_server';
            $WHERE_ROLE='AND crs.id_config_role=:id_config_role';
            $this->connSQL->bind('id_config_role',$id_config_role);
        } else {
            $JOIN_ROLE='';
            $WHERE_ROLE='';
        }
        $lib='
        SELECT
            ce.id_config_environment,
            CASE
                WHEN ce.environment_description IS NULL THEN "'.OTHERS.'"
            ELSE ce.environment_description
            END AS environment_description
        FROM config_server cs
        LEFT OUTER JOIN config_environment_server ces
            ON cs.id_config_server=ces.id_config_server
        LEFT OUTER JOIN config_environment ce
            ON ces.id_config_environment=ce.id_config_environment
        '.$JOIN_ROLE.'
        LEFT JOIN config_server_project csp
            ON cs.id_config_server=csp.id_config_server
        LEFT JOIN perm_project_group ppg
            ON ppg.id_config_project=csp.id_config_project
        LEFT JOIN auth_group ag
            ON ag.id_auth_group=ppg.id_auth_group
        LEFT JOIN auth_user_group aug
            ON aug.id_auth_group=ag.id_auth_group
        WHERE  csp.id_config_project=:id_config_project
            AND aug.id_auth_user=:id_auth_user
            '.$WHERE_ROLE.'
        GROUP BY id_config_environment, environment_description
        ORDER BY environment_description';

        $this->connSQL->bind('id_config_project',$this->id_config_project);
        $this->connSQL->bind('id_auth_user',$this->id_auth_user);
        return $this->connSQL->query($lib);
    }
}

