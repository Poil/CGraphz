<?php	
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
        //addAggregation('cpu','CPU');

		function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
        $('figcaption').each(function(){
            var src=$(this).parent().children().filter('.imggraph').first().attr('src');
            var tabSrc=src.split("&p=");
            if(tabSrc.length > 1){
                var urlSrc="&p="+tabSrc[1];
                var id_prj=getParameterByName('id_project');
                var hostname=getParameterByName('f_host');

                var forKnowProject="";
        <?php
            if(isset($_SESSION['profile']) && ($_SESSION['profile']=="admin" || $_SESSION['profile']=="staff")){
                echo 'if(id_prj!="") forKnowProject="&id_project="+id_prj;
                      else forKnowProject="&f_host="+hostname;';
            }else{
                echo 'forKnowProject="&f_host="+hostname;';
            }
        ?>

                $(this).append('<a class="pull-right" href="<?php echo DIR_WEBROOT; ?>/index.php?module=dashboard&component=compare'+forKnowProject+urlSrc+'">Compare</a>');
            }
        });

        $('div#bs-navbar-collapse-plugin').append('<div class="form-group pull-right" style="margin-bottom : 0px;"><input id="filtreGraph" type="text" class="form-control" placeholder="Filtrer graph..."></div>');

        $.expr[':'].attrCaseInsensitive = function(node, stackIndex, properties){
            var args = properties[3].split(',').map(function(arg) {
                return arg.replace(/^\s*["']|["']\s*$/g, '');
            });
            return $(node).attr(args[0]).toLowerCase().indexOf(args[1]) > -1;
        };

		$('#filtreGraph').keyup(function(){
            var title=$(this).val();

            if(title!=""){
                $('figcaption:not(:hidden):not(:attrCaseInsensitive(title, "'+title.toLowerCase()+'"))').each(function(){
                    $(this).parent().hide();
                });


                $('figcaption:attrCaseInsensitive(title, "'+title.toLowerCase()+'"):hidden').each(function(){
                    $(this).parent().show();
                });
            }else{
                $('figcaption[title]:hidden').each(function(){
                    $(this).parent().show();
                });
            }

            $('#dashboard h2,#dashboard h3,#dashboard h4').each(function(){ $(this).show()});

            var elem_suivant=null;
            $($('#dashboard h2,#dashboard h3,#dashboard h4,#dashboard figure:not(:hidden)').get().reverse()).each(function(){
                var elem_tagName=$(this).prop("tagName");
                if(elem_tagName != "FIGURE"){
                    if(elem_tagName=="H4"){
                        if(elem_suivant === null || elem_suivant != "FIGURE"){
                            $(this).hide();
                        }else{
                            elem_suivant=$(this);
                        }
                    }else if(elem_tagName=="H3"){
                        if(elem_suivant === null || elem_suivant != "FIGURE"){
                            $(this).hide();
                        }else{
                            elem_suivant=$(this);
                        }
                    }else if(elem_tagName=="H2"){
                        if(elem_suivant === null || elem_suivant != "FIGURE"){
                            $(this).hide();
                        }else{
                            elem_suivant=$(this);
                        }
                    }
                }else{
                    elem_suivant=elem_tagName;
                }
            });
        });
    });
?>
