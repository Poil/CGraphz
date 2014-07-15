<?php

# generate identifier that collectd's FLUSH command understands
function collectd_identifier($host, $plugin, $pinst, $type, $tinst) {
	global $CONFIG;

	$identifier = sprintf('%s/%s%s%s/%s%s%s', $host,
		$plugin, strlen($pinst) ? '-' : '', $pinst,
		$type, strlen($tinst) ? '-' : '', $tinst);

	if (is_file($CONFIG['datadir'].'/'.$identifier.'.rrd'))
		return $identifier;
	else
		return FALSE;
}

function rrdcached_flush($socket, $cmd) {
	$log = new LOG();
	$r = fwrite($socket, $cmd, strlen($cmd));
	if ($r === false || $r != strlen($cmd)) {
		$log->write(sprintf('ERROR: Failed to write full command to unix-socket: %d out of %d written',
			$r === false ? -1 : $r, strlen($cmd)));
		return FALSE;
	}
	
	$resp = fgets($socket,128);
	if ($resp === false) {
		$log->write(sprintf('ERROR: Failed to read response from collectd for command: %s',
			trim($cmd)));
		return FALSE;
	}
	
	$n = (int)$resp;
	while ($n-- > 0)
		fgets($socket,128);
	
	return TRUE;
}

# tell collectd to FLUSH all data of the identifier(s)
function collectd_flush($identifier) {
	global $CONFIG;
	$log = new LOG();
	if (!$CONFIG['socket'])
		return FALSE;
	if (!$identifier || (is_array($identifier) && count($identifier) == 0) || !(is_string($identifier) || is_array($identifier)))
		return FALSE;
	// Tableau contenant les connections au sockets en fonction du plugin
	$sockets=array();
	$socket_defaut=null;
	
	$u_errno  = 0;
	$u_errmsg = '';
	if ($CONFIG['flush_type'] == 'rrd') {
		if (is_array($identifier)) {
			foreach ($identifier as $val) {
				// Permet de prendre un compte une socket différentes pour certain plugin (en fonction de la config).
				$explode1=explode("/",$val);
                $explode2=explode("-", $explode1[1]);
                $plugin=$explode2[0];				

				$connectionSocket=false;				
				//On verifie si le plugin à une config special
				if(isset($CONFIG['socket_plugin']) && isset($CONFIG['socket_plugin'][$plugin])){
					$rrd_cached_name=$CONFIG['socket_plugin'][$plugin];
					if(!isset($CONFIG['list_socket'][$rrd_cached_name])){
						$rrd_cached_name="default";
					}

					// On verifie si la connection à deja été ouverte
					if(isset($sockets[$rrd_cached_name])){
						$connectionSocket=true;
						$socket=$sockets[$rrd_cached_name];
					//Sinon on l'ouvre
					}else{
						if($sockets[$rrd_cached_name]=@fsockopen($CONFIG['list_socket'][$rrd_cached_name], 0, $u_errno, $u_errmsg)){
							$connectionSocket=true;
							$socket=$sockets[$rrd_cached_name];
						}			
					}
				}else{
					if($socket_defaut==null){
						if ($socket_defaut = @fsockopen($CONFIG['socket'], 0, $u_errno, $u_errmsg)) {
							$connectionSocket=true;
                            $socket=$socket_defaut;
						}
					}else{
						$connectionSocket=true;
                        $socket=$socket_defaut;
					}
				}
			
				if($connectionSocket){
					$cmd = 'FLUSH '.$CONFIG['datadir'].'/'.$val.'.rrd'."\n";
					rrdcached_flush($socket, $cmd);
				}else{
					fclose($socket_defaut);
					foreach($sockets as $s){
						fclose($s);
					}
					return FALSE;
				}	
			}
			
		} else {
			// Permet de prendre un compte une socket différentes pour certain plugin (en fonction de la config).
            $explode1=explode("/",$val);
            $explode2=explode("-", $explode1[1]);
            $plugin=$explode2[0];

            $connectionSocket=false;
            
			//On verifie si le plugin à une config special
            if(isset($CONFIG['socket_plugin']) && isset($CONFIG['socket_plugin'][$plugin])){
                $rrd_cached_name=$CONFIG['socket_plugin'][$plugin];
                if(!isset($CONFIG['list_socket'][$rrd_cached_name])){
                    $rrd_cached_name="default";
                }

                // On verifie si la connection à deja été ouverte
                if(isset($sockets[$rrd_cached_name])){
                    $connectionSocket=true;
                    $socket=$sockets[$rrd_cached_name];
                //Sinon on l'ouvre
                }else{
                    if($sockets[$rrd_cached_name]=@fsockopen($CONFIG['list_socket'][$rrd_cached_name], 0, $u_errno, $u_errmsg)){
                        $connectionSocket=true;
                        $socket=$sockets[$rrd_cached_name];
                    }
                }
            }else{
                if($socket_defaut==null){
                    if ($socket_defaut = @fsockopen($CONFIG['socket'], 0, $u_errno, $u_errmsg)) {
                        $connectionSocket=true;
                        $socket=$socket_defaut;
                    }
                }else{
                    $connectionSocket=true;
                    $socket=$socket_defaut;
                }
            }


			if($connectionSocket){
                $cmd = 'FLUSH '.$CONFIG['datadir'].'/'.$val.'.rrd'."\n";
                rrdcached_flush($socket, $cmd);
            }else{
                fclose($socket_defaut);
                foreach($sockets as $s){
                    fclose($s);
                }
                return FALSE;
            }














			/*//On verifie si le plugin à une config special
			if(isset($CONFIG['socket_plugin']) && isset($CONFIG['socket_plugin'][$plugin])){
                // On verifie si la connection à deja été ouverte
                if(isset($sockets[$plugin])){
                    $connectionSocket=true;
                    $socket=$sockets[$plugin];
                //Sinon on l'ouvre
                }else{
                    if($sockets[$plugin]=@fsockopen($CONFIG['socket_plugin'][$plugin], 0, $u_errno, $u_errmsg)){
                        $connectionSocket=true;
                        $socket=$sockets[$plugin];
                    }
                }
            }else{
                if($socket_defaut==null){
                    if ($socket_defaut = @fsockopen($CONFIG['socket'], 0, $u_errno, $u_errmsg)) {
                        $connectionSocket=true;
                        $socket=$socket_defaut;
                    }
                }else{
                    $connectionSocket=true;
                    $socket=$socket_defaut;
                }
            }

            if($connectionSocket){
                $cmd = 'FLUSH '.$CONFIG['datadir'].'/'.$val.'.rrd'."\n";
                rrdcached_flush($socket, $cmd);
            }else{
				fclose($socket_defaut);
				foreach($sockets as $s){
					fclose($s);
		        }
                return FALSE;
            }*/
		}
		fclose($socket_defaut);
        foreach($sockets as $s){
            fclose($s);
        }
				
		return TRUE;
	} else if ($CONFIG['flush_type'] == 'collectd'){
		if ($socket = @fsockopen($CONFIG['socket'], 0, $u_errno, $u_errmsg)) {
	
			if (is_array($identifier)) {
				foreach ($identifier as $val)
					$cmd .= sprintf(' identifier="%s"', $val);
			} else {
				$cmd .= sprintf(' identifier="%s"', $identifier);
			}
			$cmd .= "\n";
				
			$r = fwrite($socket, $cmd, strlen($cmd));
			if ($r === false || $r != strlen($cmd)) {
				$log->write(sprintf('ERROR: Failed to write full command to unix-socket: %d out of %d written',
				$r === false ? -1 : $r, strlen($cmd)));
				return FALSE;
			}
				
			$resp = fgets($socket);
			if ($resp === false) {
				$log->write(sprintf('ERROR: Failed to read response from collectd for command: %s',
				trim($cmd)));
				return FALSE;
			}
				
			$n = (int)$resp;
			while ($n-- > 0)
				fgets($socket);
		}else{
			$log->write(sprintf('ERROR: Failed to open unix-socket to collectd: %d: %s', $u_errno, $u_errmsg));
		    return FALSE;
	    }


		fclose($socket);
	
		return TRUE;
	}
	return TRUE;
}

