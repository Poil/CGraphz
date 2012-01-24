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
		if (isset($_GET['f_logout'])) {
			$this->logout();
		} else if (isset($_POST['f_submit_auth'])) {
			$this->user=mysql_escape_string($_POST['f_user']);
			$this->passwd=mysql_escape_string($_POST['f_passwd']);
			
			$res=$this->connSQL->getRow('SELECT `id_auth_user`, `user`, `type` FROM auth_user WHERE `user`="'.$this->user.'"');
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
		$res=$this->connSQL->getRow($lib);
		if (@$res->user == $this->user) {
			$_SESSION['S_USER']=$res->user;
			$_SESSION['S_PASSWD']=$res->passwd;
			$_SESSION['S_ID_USER']=$this->id_auth_user;
			return true;
		} else {
			return false;
		}
	}
	
	function logout(){ // détruire la session
		session_unset();
		session_destroy();
		//header('Location: https://'.$_SERVER['SERVER_NAME'].DIR_WEBROOT);
		if (isset($_SERVER['HTTPS'])) {
        	header('Location: https://'.$_SERVER['SERVER_NAME'].DIR_WEBROOT);
      	} else {
       		header('Location: http://'.$_SERVER['SERVER_NAME'].DIR_WEBROOT);
      	}
		die();
	}
}
?>
