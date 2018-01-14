<?php
if (isset($_POST['f_del_server_check'])) {
   $f_server_name_to_del=filter_input(INPUT_POST,'f_server_name_to_del',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
   if (count($f_server_name_to_del)>0) {
      foreach ($f_server_name_to_del as $server_name) {

         $connSQL=new DB();
         $connSQL->bind('server_name',$server_name);
         $lib='SELECT id_config_server FROM config_server WHERE server_name=:server_name';
         $cur_todelete_server=$connSQL->row($lib);

         $connSQL->bind('id_config_server',$cur_todelete_server->id_config_server);
         $lib='DELETE FROM config_role_server WHERE id_config_server=:id_config_server';
         $connSQL->query($lib);

         $connSQL->bind('id_config_server',$cur_todelete_server->id_config_server);
         $lib='DELETE FROM config_environment_server WHERE id_config_server=:id_config_server';
         $connSQL->query($lib);

         $connSQL->bind('id_config_server',$cur_todelete_server->id_config_server);
         $lib='DELETE FROM config_server_project WHERE id_config_server=:id_config_server';
         $connSQL->query($lib);

         $connSQL->bind('id_config_server',$cur_todelete_server->id_config_server);
         $lib='DELETE FROM config_server WHERE id_config_server=:id_config_server';
         $connSQL->query($lib);
      }
   }
}
?>
