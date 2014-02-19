<?php

class LDAP {
	// Attribut du login du LDAP
	var $LDAP_login;
	// Attribut du password du LDAP
	var $LDAP_password;
	// Attribut de l'hôte du LDAP
	var $LDAP_host;
	var $LDAP_port;
	// Attribut de connection
	var $connect;
	//Identification
	var $identification;

	// Définition du constructeur
	function __construct($host, $port, $login, $password) {
		// Initialisation des attributs
		$this->LDAP_login = $login;
		$this->LDAP_password = $password;
		$this->LDAP_host = $host;
		$this->LDAP_port = $port;
	}
	
	//fonction de connection
	function connect() {
		// Connection à LDAP
		$this->connect = ldap_connect($this->LDAP_host.':'.$this->LDAP_port);

		// Vérification de la connection
		if (!$this->connect){
			// Affichage du message d'erreur
			echo "<b>Erreur :</b> Connection au serveur impossible impossible<br />";
			return false;
		} else {
			ldap_set_option($this->connect,LDAP_OPT_PROTOCOL_VERSION,3);
 			ldap_set_option($this->connect,LDAP_OPT_REFERRALS,0);			
			return true;
		}
	}
	
	// Méthode Identification()
	function identification () {
		// Exécution de l'identification
		$ident = @ldap_bind($this->connect, 'uid='.$this->LDAP_login.','.LDAP_TREE, $this->LDAP_password);

		//Vérification de la connection
		if ($ident) {
			$this->identification = $ident;
			return true;
		} else {
			echo "Echec d'identification<br />";
			return false;
		}
	}
	
	//fonction recherche
	function recherche($Nom) {
		echo 'Recherchons (sn='.$Nom.') ...';
		// Recherche par nom
		$search = ldap_search($this->connect, LDAP_TREE, "sn=$Nom"); 
		echo 'Le résultat de la recherche est ' . $search . '<br />';
		echo 'Le nombre d\'entrées retournées est ' . ldap_count_entries($this->connect,$search) . '<br />';
		echo 'Lecture des entrées ...<br />';
		$info = ldap_get_entries($this->connect, $search);
		echo 'Données pour ' . $info["count"] . ' entrées:<br />';

		for ($i=0; $i<$info["count"]; $i++) {
			echo 'dn est : ' . $info[$i]["dn"] . '<br />';
			echo 'premiere entree cn : ' . $info[$i]["cn"][0] . '<br />';
			echo 'premiere entree sn : ' . $info[$i]["sn"][0] . '<br />';
			echo 'premier email : ' . $info[$i]["mail"][0] . '<br />';
			echo 'premier givenName : ' . $info[$i]["givenName"][0] . '<br />';
			echo 'premier uid : ' . $info[$i]["uid"][0] . '<br />';
		}
	}
	
	// Méthode deconnect()
	function deconnect (){
		// Déconnection
		$deconnect = ldap_unbind($this->connect);
		if(!$deconnect)
		ldap_close($this->connect);//c les bretelles et la ceinture :)
	} //fin de déconnexion
}

