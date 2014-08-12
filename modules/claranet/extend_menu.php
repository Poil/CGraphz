<?php
	// Affiche un la barre de navigation en fonction du profile

	if(isset($_SESSION['profile'])){
		//Récupération du nom de projet et des serveurs.
        include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/serverProjectSession.php');


		echo "
             <style>
                    .projetLink:hover{
                        color : #2a5685;
                    }
                    #textCheckFiltre, #filtreClient,select,select option{
                        cursor:pointer;
                    }
                    .imggraph{
                        padding: 0px;
                        margin: 3px;
                    }
            </style>";

		if($_SESSION['profile']=='admin' || $_SESSION['profile']=='staff'){
			include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/menu/nav_menu_staff.php');
		}else{
			include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/menu/nav_menu.php');
		}

		echo '<p class="navbar-text pull-right" style="margin-top : 5px;">';


        if(isset($_GET['f_host'])){
            if(strpos($_GET['f_host'],'WEB') !== false) {
                    echo '<a href="../#/dashboard?grp='.$_GET['id_project'].'" style="color: #ffffff; background-color: transparent; text-decoration: none;">PeekIn</a>';

            }else{
                    echo '<a href="../#/details/'.$_GET['f_host'].'?grp='.$_GET['id_project'].'" style="color: #ffffff; background-color: transparent; text-decoration: none;">PeekIn</a>';
            }
        }else{
            echo '<a href="../#dashboard/" style="color: #ffffff; background-color: transparent; text-decoration: none;">PeekIn</a>';
        }
        echo "</p>";


?>




<script type='text/javascript'>
	$('#selectServer').change(function(){
		var srv='';
		$('#selectServer option:selected').each(function(){
			srv=$(this).val();
		});
		if(srv!="-1"){
			window.location.href = '<?php echo DIR_WEBROOT; ?>/index.php?module=dashboard&component=light'+srv;
		}
	});

	$('#selectProject').change(function(){
		// Redirection vers la page de login si la Session n'existe plus
		$.get("<?php echo DIR_WEBROOT ?>/modules/claranet/ajax/checkSession.ajax.php",function(data){
			if(data=="no"){
				window.location="../";
			}
		});
		$('#selectServer').html("");
		var prj='';
		$('#selectProject option:selected').each(function(){
			prj=$(this).val();
		});
		//Requète ajax récuperant les serveurs liés au projet dans la session.
		$.ajax({
			type: 'GET',
			url: '<?php echo DIR_WEBROOT; ?>/modules/claranet/ajax/getServerByProject<?php if($_SESSION["profile"]!="user") echo "Staff"; ?>.ajax.php',
			data: 'project='+prj,
			success: function(msg){
				$('#selectServer').html(msg);
			}
		});
	});
</script>


<?php

	}

?>
