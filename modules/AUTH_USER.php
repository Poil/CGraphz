<?php
class AUTH_USER {
  private $user;
  private $passwd;
  private $id_auth_user;

  function __construct() {
    if(!isset($_SESSION)) {
      session_name('CGRAPHZ');
      session_start();
    }
    $this->connSQL=new DB();
  }

  function verif_auth() {
    $try_auth=False;
    // Auth Form
    if (isset($_POST['f_submit_auth'])) {
      $this->user=mysql_escape_string($_POST['f_user']);
      $this->passwd=mysql_escape_string($_POST['f_passwd']);
      $try_auth=True;
      // Auth Basic if "&f_basic_auth=true" WARNING You can't logout with BasicAuth (see http://httpd.apache.org/docs/1.3/howto/auth.html How do I log out?)
    } else if (isset($_GET['f_basic_auth']) && !isset($_SESSION['S_USER']) && !isset($_SERVER['PHP_AUTH_USER'])) {
      // Basic Auth ?
      header('WWW-Authenticate: Basic realm="CGraphz BasicAuth"');
      header('HTTP/1.0 401 Unauthorized');
    } else if (isset($_GET['f_basic_auth']) && isset($_SERVER['PHP_AUTH_USER'])) {
      $this->user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
      $this->passwd = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
      $try_auth=True;
    } else if (AUTH_TYPE != 'default') {
      include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/extend_auth.php');
    }

    if (isset($_GET['f_logout'])) {
      $this->logout();
    } else if ($try_auth==True) {
      $res=$this->connSQL->row('SELECT id_auth_user, user, type FROM auth_user WHERE user="'.$this->user.'"');
      if (!$res) {
        return false;
      }
      else if ($res->user) { // L'utilisateur est connu dans la BDD
        $this->id_auth_user=$res->id_auth_user;
        if ($res->type=='mysql'){ // est ce un compte mysql
          if ($this->verif_auth_mysql(true)) {
            return true;
          } else {
            return false;
          }
        } else if ($res->type=='ldap') { // est ce un compte LDAP
          if ($this->verif_auth_ldap(true)) { // on verifie dans le LDAP
            return true;
          } else {
            return false;
          }
        }
      } else { // L'utilisateur n'est pas connu -- On renvoi true mais le mec aura le droit a rien ?
        if ($this->verif_auth_ldap(false)) { // on verifie dans le LDAP et on enregistre en base
          echo 'Vous ne semblez pas avoir accès à cette application<br />';
          return false;
        } else {
          return false;
        }
      }
    } else if (isset($_SESSION['S_USER'])) {
      $this->user=mysql_escape_string($_SESSION['S_USER']);
      $this->passwd=mysql_escape_string($_SESSION['S_PASSWD']);
      $this->id_auth_user=intval($_SESSION['S_ID_USER']);
      if ($this->verif_auth_mysql(false)) {
        return true;
      } if ($this->verif_auth_ldap(false)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  function verif_auth_ldap($new_user) { // Verification du compte dans le LDAP
    $this->conn_LDAP_Master=new LDAP(LDAP_HOST, LDAP_PORT, $this->user, $this->passwd);
    if( $this->conn_LDAP_Master->connect() ) {
      // faire l'authentification LDAP
      if ($this->conn_LDAP_Master->identification()) {
        $_SESSION['S_USER']=$this->user;
        $_SESSION['S_PASSWD']=$this->passwd;
        $_SESSION['S_ID_USER']=$this->id_auth_user;
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  function verif_auth_mysql($new_ident) {
    if ($new_ident==true) {
      $lib='SELECT `user`,`passwd` FROM auth_user WHERE `user`="'.$this->user.'" AND `passwd`=password("'.$this->passwd.'")';
    } else {
      $lib='SELECT `user`,`passwd` FROM auth_user WHERE `user`="'.$this->user.'" AND `passwd`="'.$this->passwd.'"';
    }
    $res=$this->connSQL->row($lib);
    if ($res->user == $this->user) {
      $_SESSION['S_USER']=$res->user;
      $_SESSION['S_PASSWD']=$res->passwd;
      $_SESSION['S_ID_USER']=$this->id_auth_user;
      return true;
    } else {
      return false;
    }
  }

  function check_access_right($host) {
    if (!$this->verif_auth()) { return false; }

    $lib='
      SELECT
      cs.server_name,
      COALESCE(cs.collectd_version,"'.COLLECTD_DEFAULT_VERSION.'") as collectd_version
        FROM config_server cs
        LEFT JOIN config_server_project csp
        ON cs.id_config_server=csp.id_config_server
        LEFT JOIN perm_project_group ppg
        ON csp.id_config_project=ppg.id_config_project
        LEFT JOIN auth_user_group aug
        ON ppg.id_auth_group=aug.id_auth_group
        WHERE (cs.server_name=:host)
        AND (aug.id_auth_user=:s_id_user)
        GROUP BY server_name
        ORDER BY server_name';

    $this->connSQL->bind('host', $host);
    $this->connSQL->bind('s_id_user',$_SESSION['S_ID_USER']);
    $authorized=$this->connSQL->row($lib);

    if ($host==$authorized->server_name) {
      return $authorized;
    } else if (AUTH_TYPE != 'default') {
      include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/extend_access_right.php');
    } else {
      return false;
    }
  }

  function logout(){ // détruire la session
    session_unset();
    session_destroy();
    if (isset($_SERVER['HTTPS'])) {
      header('Location: https://'.$_SERVER['SERVER_NAME'].DIR_WEBROOT);
    } else {
      header('Location: http://'.$_SERVER['SERVER_NAME'].DIR_WEBROOT);
    }
    die();
  }
}
