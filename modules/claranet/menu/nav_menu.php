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

