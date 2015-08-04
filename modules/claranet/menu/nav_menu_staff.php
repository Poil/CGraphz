<?php
	echo '
	<form class="navbar-form navbar-left" role="search" style="margin-top : 0px;">
		<div class="form-group">
			<p style="color: #ffffff; background-color: transparent; text-decoration: none; margin-top : 15px;">Projets : </p>
        </div>
		<div class="form-group">
			<select id="selectProject" >';

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_URL, CLARATACT_WS."/REST/contact/getProjectsForStaff.php");
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
		$_GET['project']=$nameProject;
		include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/ajax/getServerByProjectStaff.ajax.php');
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

<div style="width : 10px; height : 5px; display : inline-block;">
	<!-- Permet de mettre un espace horizontal ( width ) sur grand ecran et un epsace vertical ( height ) en responsive !-->
</div>
<div class="form-group">
	<p style="color: #ffffff; background-color: transparent; text-decoration: none; margin-top:15px;">Vue : </p>
</div>
<div class="form-group">  
	<select id="selectView">
<?php	
	//Modifie l'id utilisateur ( dans CGraphZ ) pour afficher les graphes en fonction du filtre ( staff, guest... )
	if(isset($_SESSION['filtre']))
		$_SESSION["S_ID_USER"]=$_SESSION['filtre'];
	
	//Si l'utilisateur n'est pas un user alors on affiche la checkbox de vue client.
	$connSQL=new DB();
	
	$requete="SELECT id_auth_user,name_view FROM view order by name_view;";

	$res=$connSQL->query($requete);
	
	
	foreach($res as $row){
		echo '<option '.(($_SESSION['S_ID_USER']==$row->id_auth_user)? 'selected':'').' value="'.$row->id_auth_user.'">'.$row->name_view.'</option>';
	}
?>	    
	</select>
</div>
</form>

<script type="text/javascript">
	$('#selectView').on('change',function(){
		window.location.href = '<?php echo DIR_WEBROOT; ?>/modules/claranet/filtre.php?c='+$(this).val();
	});
</script>




<?php
	if($component=="light"){
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
                    data: '<?php echo 'f_host='.$_GET['f_host'].'&idUser='.$_SESSION["S_ID_USER"].'&timerange='.((isset($_SESSION['time_range'])) ? $_SESSION['time_range'] : "").'&timestart='.((isset($_SESSION['time_start'])) ? $_SESSION['time_start'] : "").'&timeend='.((isset($_SESSION['time_end'])) ? $_SESSION['time_end'] : "");?>',
                    success: function(msg){
                        if(msg=="all"){
                        	$('#dashboard figure img').addClass('grapheClient');
                        }else if(msg!=""){
	                        var tabSrcClient=msg.split('|');
	                        for(var i = 0 ; i < tabSrcClient.length ; i++){
	                            // Ne pas prendre en compte les variables de temps ( ce qui il y a après le &s )
	                            var src=tabSrcClient[i].split('&s');
	                            $('#dashboard figure img[src*="'+src[0]+'"]').addClass('grapheClient');
							}
	
							// Cas particulier de l'aggregation
							$('#dashboard figure img[src*="&t=aggregation"]').addClass('grapheClient');
                        }
                    }
                });
            });
		</script>
<?php
    }
?>