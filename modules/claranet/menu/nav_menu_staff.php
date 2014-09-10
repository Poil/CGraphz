<?php
	echo '
	<form class="navbar-form navbar-left" role="search" style="margin-top : 0px;">
		<div class="form-group">
			<p style="color: #ffffff; background-color: transparent; text-decoration: none; margin-top : 15px;">Projets : </p>
        </div>
		<div class="form-group">
			<select id="selectProject" >';

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, "http://claratact.fr.clara.net/REST/contact/getProjectsForStaff.php");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);

	$postfields=array('login'=>'FR-Claratact-API','pass'=>'phax5d!idhj8h');
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

	$return=curl_exec($curl);

	curl_close($curl);
	if($nameProject==""){
		echo '  <option value=""></option>';
	}
	foreach(json_decode($return) as $project){
		$selected="";
		if($nameProject==$project->id){
			$selected="selected ";
		}

		echo '  <option '.$selected.'value="'.$project->id.'">'.$project->name.'</option>';
	}

	echo '</select></div>';
?>

<?php
	//Affichage du select des serveurs
	echo '<div class="form-group">
			  <p style="color: #ffffff; background-color: transparent; text-decoration: none; margin-top:15px;">Serveurs : </p>
		  </div>
		  <div class="form-group">  
			<select id="selectServer">';

	if($nameProject==""){
		$nameHost=(isset($_GET['f_host'])) ? $_GET['f_host'] : "";
		echo '  <option value="'.$nameHost.'">'.$nameHost.'</option>';
	}else{
		//Si on a trouvé un nom de projet alors on cherche dans la base de données de claratact la liste des serveurs de ce projet.
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, "http://claratact.fr.clara.net/REST/Projet/getProjectHosts.php");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);

		$postfields=array('login'=>'FR-Claratact-API','pass'=>'phax5d!idhj8h','idProjet'=>$nameProject);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

		$return=curl_exec($curl);

		curl_close($curl);
		$return=json_decode($return);
		if(isset($_GET["f_host"])){
			echo '<option value=""></option>';
		}
		foreach($return->hosts as $server){
			$selected="";
			if($_GET["f_host"]==$server->name){
				$selected="selected ";
			}

			echo '<option '.$selected.'value="&f_host='.$server->name.'&id_project='.$nameProject.'">'.$server->name.'</option>';
		}
		foreach($return->wpm as $wpmName){
			$selected="";
			if($_GET["f_host"]==$wpmName){
				$selected="selected ";
			}

			echo '  <option '.$selected.'value="&f_host='.$wpmName.'&id_project='.$nameProject.'">'.$wpmName.'</option>';
		}
	}


	echo '</select>
		</div>';
?>
	<div style="width : 10px; height : 5px; display : inline-block;">
		<!-- Permet de mettre un espace horizontal ( width ) sur grand ecran et un epsace vertical ( height ) en responsive !-->
	</div>

	<div id="f_form_find_server" class="form-group">
		<input type="text" name="f_find_server" class="form-control" placeholder="<?php echo SEARCH ?>" autocomplete="off" style="margin-top : 8px;">
	</div>

<script type="text/javascript">
	//Permet l'autocomplete du search
	jQuery('#f_form_find_server input[name="f_find_server"]').liveSearch({url: '<?php echo DIR_WEBROOT."/modules/".AUTH_TYPE ?>/ajax/serverSearchStaff.ajax.php' + '?f_q='});
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

<?php	

	//Si l'utilisateur n'est pas un user alors on affiche la checkbox de vue client.
	$connSQL=new DB();
	$idStaff=$_SESSION["S_ID_USER"];
	$requete="SELECT id_auth_user FROM auth_user WHERE user='guest'";

	$res=$connSQL->query($requete);
	$idGuest=$res[0]->id_auth_user;

?>

<div style="width : 10px; height : 5px; display : inline-block;">
	<!-- Permet de mettre un espace horizontal ( width ) sur grand ecran et un epsace vertical ( height ) en responsive !-->
</div>

<div class="input-group" id="checkFiltre" style="width : 30px; margin-top : 8px;">
	<span class="input-group-addon">
		<input <?php if(!isset($_SESSION['filtre']) || $_SESSION['filtre']!=$idStaff){ echo "checked ";}?>id="filtreClient"type="checkbox">
	</span>
	<span id="textCheckFiltre" class="input-group-addon" style="width:65px;padding-left:0px;">Vue client</span>
</div>
</form>

<script type="text/javascript">
	function modifeFiltre(){
	<?php
		if(!isset($_SESSION['filtre']) || $_SESSION['filtre']!=$idStaff){
			echo "window.location.href = '".DIR_WEBROOT."/modules/claranet/filtre.php?c=$idStaff';";
		}else{
			echo "window.location.href = '".DIR_WEBROOT."/modules/claranet/filtre.php?c=$idGuest';";
		}
	?>

	}

	$('#textCheckFiltre').on('click',function(){
		if($('#filtreClient').is(":checked")){
			$('#filtreClient').prop("checked",false);
		}else{
			$('#filtreClient').prop("checked",true);
		}
		modifeFiltre();
	});
	$('#filtreClient').change(modifeFiltre);
</script>




<?php
	if(isset($_SESSION['filtre']) && $_SESSION['filtre']==$idStaff && isset($_GET['f_host'])){
	//ajax entoure image graphe
?>
		<style>
			img:not(.grapheClient){
				border:3px solid red;
				border-color: rgba(255, 0, 0, 0.4);
			}
			.grapheClient{
				border:3px solid black;
				border-color: rgba(0, 0, 0, 0);
			}
		</style>

		<script type="text/javascript">
			$(document).ready(function(){
                $.ajax({
                    type: 'GET',
                    url: '<?php echo DIR_WEBROOT; ?>/modules/claranet/ajax/getGraphClient.ajax.php',
                    data: '<?php echo 'f_host='.$_GET['f_host'].'&idGuest='.$idGuest.'&timerange='.((isset($_SESSION['time_range'])) ? $_SESSION['time_range'] : "").'&timestart='.((isset($_SESSION['time_start'])) ? $_SESSION['time_start'] : "").'&timeend='.((isset($_SESSION['time_end'])) ? $_SESSION['time_end'] : "");?>',
                    success: function(msg){
                        var tabSrcClient=msg.split('|');
                        for(var i = 0 ; i < tabSrcClient.length ; i++){
                            // Ne pas prendre en compte les variables de temps ( ce qui il y a après le &s )
                            var src=tabSrcClient[i].split('&s');
                            $('[src*="'+src[0]+'"]').addClass('grapheClient');
						}

						// Cas particulier de l'aggregation
						$('[src*="&t=aggregation"]').addClass('grapheClient');
                    }
                });
            });
		</script>
<?php
    }
?>

<?php
	//Modifie l'id utilisateur ( dans CGraphZ ) pour afficher les graphes en fonction du filtre ( staff ou guest )
	$_SESSION["S_ID_USER"]=isset($_SESSION['filtre']) ? $_SESSION['filtre'] : $idGuest;
	
?>

