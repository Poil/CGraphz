<?php
	//Affichage du select des projet
	echo '
			
	<script>
		$(function(){
			$("#selectProject").combobox();
			$("#selectProject").on("change",changeProjet);
			
			$("#selectServer").on("change",changeServer);
		});
	</script>
	<form class="navbar-form navbar-left" role="search" style="margin-top : 0px;">
        <div class="form-group">
			<p style="color: #ffffff; background-color: transparent; text-decoration: none; margin-top : 15px;">Projets : </p>
        </div>
		<div class="form-group" id="divSelectProject">
			<select id="selectProject">';

	//Si on est un user alors on affiche les projets contenu dans la session.

	//Si aucun nom de projet n'est trouvé alors on affiche tous les serveurs.
	if($nameProject==""){
		$all=true;
		$selected="selected ";
	}else{
		$all=false;
		$selected="";
	}
	echo '    <option '.$selected.'class="projetLink" value="-1">All projects</option>';
	foreach($tabHosts as $nomProjet => $listeHosts){
		$selected="";
		if($nameProject==$nomProjet){
			$selected="selected ";
		}
		echo '<option '.$selected.'class="projetLink">'.$nomProjet.'</option>';
	}
	echo '</select>
	</div>';

	echo '
	<div style="width : 5px; height : 1px; display : inline-block;">
		<!-- Permet de mettre un espace horizontal ( width ) sur grand ecran et un epsace vertical ( height ) en responsive !-->
	</div>';

	//Affichage du select des serveurs
	echo '<div class="form-group">
			<p style="color: #ffffff; background-color: transparent; text-decoration: none; margin-top:15px;">Serveurs : </p>
		  </div>
		  <div class="form-group" id="divSelectServer">
			<select id="selectServer">';

	if($nameProject=="") $_GET['project']=-1;
    else $_GET['project']=$nameProject;
    include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/ajax/getServerByProject.ajax.php');

?>
		</select>
	</div>
	<div style="width : 10px; height : 5px; display : inline-block;">
        <!-- Permet de mettre un espace horizontal ( width ) sur grand ecran et un epsace vertical ( height ) en responsive !-->
    </div>	

	<div id="f_form_find_server" class="form-group">
		<input type="text" name="f_find_server" class="form-control" placeholder="<?php echo SEARCH ?>" autocomplete="off" style="margin-top : 8px;">
	</div>
	
	<?php
			//Si l'utilisateur n'est pas un user alors on affiche la checkbox de vue client.
			$connSQL=new DB();
			
			if(isset($_SESSION['hierarchy'])){
				$prjs=array();
			
				foreach(json_decode($_SESSION['hierarchy'],true) as $prj){
					$prjs[]=$prj['id'];
				}
				
				if(!empty($prjs)){
					$requeteView="SELECT au.id_auth_user, v.name_view
							FROM project_view as pv
							INNER JOIN view as v
								ON pv.id_view=v.id_view
							INNER JOIN auth_user as au
								ON au.id_auth_user=v.id_auth_user
							WHERE id_project in (".implode(",",array_filter($prjs)).");";
					
					$views=$connSQL->query($requeteView);
					
					
					if(!empty($views)){
						// On recupère l'id du user guest
						$requeteGuest='SELECT id_auth_user
									FROM auth_user
									WHERE user="guest"
									LIMIT 1;';
						
						$res=$connSQL->query($requeteGuest);
						// On affiche l'option de vue par defaut
						if(isset($res[0])){
							$guest=$res[0];
							echo "
							<div style='width : 10px; height : 5px; display : inline-block;'>
								<!-- Permet de mettre un espace horizontal ( width ) sur grand ecran et un epsace vertical ( height ) en responsive !-->
							</div>
							<div class='form-group'>
								<p style='color: #ffffff; background-color: transparent; text-decoration: none; margin-top:15px;'>Vue : </p>
							</div>
							<div class='form-group'>  
								<select id='selectView'>
									<option value='".$guest->id_auth_user."'>Defaut</otpion>";
							
							foreach($views as $index => $view){
								$isCurrentView=false;
								
								// Si il n'y a pas de filtre la vue courant est la première du user
								if(!isset($_SESSION['filtre']) && $index==0){
									$_SESSION["S_ID_USER"]=$view->id_auth_user;
									$isCurrentView=true;
								// Si il y a un filtre alors la vue courante est celle du filtre
								}else if(isset($_SESSION['filtre']) && ($view->id_auth_user==$_SESSION['filtre'])){
									$_SESSION["S_ID_USER"]=$_SESSION['filtre'];
									$isCurrentView=true;
								}
										
								echo '<option '.(($isCurrentView)? 'selected':'').' value="'.$view->id_auth_user.'">'.$view->name_view.'</option>';
							}
							
							echo "
								</select>
							</div>
							<script type='text/javascript'>
								$('#selectView').on('change',function(){
									window.location.href = '".DIR_WEBROOT."/modules/claranet/filtre.php?c='+$(this).val();
								});
							</script>";
						}
					}
				}
			}
		?>
</form>
<script type="text/javascript">
	//Permet l'autocomplete du search
	jQuery('#f_form_find_server input[name="f_find_server"]').liveSearch({url: '<?php echo DIR_WEBROOT.'/modules/'.AUTH_TYPE; ?>/ajax/serverSearch.ajax.php' + '?f_q='});
	$('#f_form_find_server input[name="f_find_server"]').keyup(function(e) {
		if(e.keyCode == 13) {
			var f_host=$('#f_form_find_server input[name="f_find_server"]').val();
			window.location.href ='./index.php?module=dashboard&component=light&f_host='+f_host;
		}else{
			$.get("<?php echo DIR_WEBROOT ?>/modules/claranet/ajax/checkSession.ajax.php",function(data){
				if(data=="no"){
					window.location="../";
				}
			});
		}
	});
</script>

