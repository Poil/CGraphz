<?php
/*****************************/
/*                           /*
/*                           /*
/*                           /*
/*****************************/
if(isset($_SESSION['user'])) {
	if (isset($_SESSION['profile']) && ($_SESSION['profile']=='admin')) {
		$this->user = isset($_SESSION['user']) ? 'staff' : '';
		$this->passwd = isset($_SESSION['user']) ? 'staff' : '';
	} else if(isset($_SESSION['profile']) && ($_SESSION['profile']=='staff')) {
		$this->user = isset($_SESSION['user']) ? 'staff' : '';
		$this->passwd = isset($_SESSION['user']) ? 'staff' : '';
	} else{
		$username="";
		$pass="";
		if(!isset($_SESSION['view'])){
			// recherche la vue pour un client
			if(isset($_SESSION['hierarchy'])){
				$prjs=array();
				
				foreach(json_decode($_SESSION['hierarchy'],true) as $prj){
					$prjs[]=$prj['id'];
				}
				
				if(!empty($prjs)){
					$requete="SELECT au.user as name
							FROM project_view as pv
							INNER JOIN view as v
								ON pv.id_view=v.id_view
							INNER JOIN auth_user as au
								ON au.id_auth_user=v.id_auth_user
							WHERE id_project in (".implode(",",$prjs).");";
					
					$connSQL=new DB();
					
					$all_user=$connSQL->query($requete);
					
					if(isset($all_user[0])){
						$user=$all_user[0];
						$username = $user->name;
						$pass = $user->name;
						
						$_SESSION['view']= $user->name;
					}
				}
			}
		}else{
			$username = $_SESSION['view'];
			$pass = $_SESSION['view'];
		}
		
		if($username!="" && $pass!=""){
			$this->user = $username;
			$this->passwd = $pass;
		}else{
			$this->user = isset($_SESSION['user']) ? 'guest' : '';
			$this->passwd = isset($_SESSION['user']) ? 'guest' : '';
		}
	}
	
	$component='dashboard';
	$try_auth=True;
}

