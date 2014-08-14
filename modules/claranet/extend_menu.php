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

		echo '<p class="navbar-text pull-right">';


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
	$(function(){
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



		function addAggregation(plugin,pluginText){
			var i=0;
			$('img[src*="&p='+plugin+'&"]').each(function(){
		        i++;
	        });
			if(i>1){
				i=0;
				$('img[src*="&p='+plugin+'&"]').each(function(){
					if(i==0){
						var new_src=$(this).attr('src').replace(/&pi=.*?&/,'&pi=&').replace(/&t=.*?&/,'&t=aggregation&');
						$(this).before('<div style="display : inline-block; min-height:34px;"><div class="btn-group" style="display:block;"><button id="seeMore'+plugin+'" type="button" class="btn btn-default" statut="less">Voir d&eacute;tails '+pluginText+'</button></div><img class="imggraph" onclick="Show_Popup($(this).attr(\'src\').split(\'?\')[1],\'604800\',\'\',\'\')" title="Click to Zoom" alt="rrd" src="'+new_src+'"></div>');
					}
				    $(this).hide();
			        i++;
		        });
	        }
			$('#seeMore'+plugin).on('click',function(){
				var seeMore=false;
            	if($('#seeMore'+plugin).attr('statut')=="less"){
            	    seeMore=true;
            	    $('#seeMore'+plugin).html('Voir agr&eacute;gation '+pluginText);
            	    $('#seeMore'+plugin).attr('statut',"more");
            	    $('#seeMore'+plugin).parent().parent().css('display',"block");
            	}else{
            	    $('#seeMore'+plugin).html('Voir d&eacute;tails '+pluginText);
            	    $('#seeMore'+plugin).attr('statut',"less");
            	    $('#seeMore'+plugin).parent().parent().css('display',"inline-block");
            	}

            	var i=0;
            	$('img[src*="&p='+plugin.toLowerCase()+'&"]').each(function(){
            	    if(i==0){
            	        if(seeMore) $(this).hide();
            	        else $(this).show();
            	    }else{
            	        if(seeMore) $(this).show();
            	        else $(this).hide();
            	    }
			        i++;
		        });
	        });


		}
		addAggregation('cpu','CPU');
	});
	
</script>


<?php

	}

?>
