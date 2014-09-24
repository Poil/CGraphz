<?php
	class memcacheSessionHandler{
		private $host = "localhost";
		private $port = 11211;
		private $lifetime = 0;
		private $memcache = null;

		public function __construct(){
			ini_set('session.gc_maxlifetime', 3600);
			
			$this->memcache = new Memcache;
			$this->memcache->connect($this->host, $this->port) or die("Error : Memcache is not ready");
			session_write_close();
			session_set_save_handler(
				array($this, "open"),
				array($this, "close"),
				array($this, "read"),
				array($this, "write"),
				array($this, "destroy"),
				array($this, "gc")
			);
		}

		public function __destruct(){
			session_write_close();
			$this->memcache->close();
		}

		public function open(){
			$this->lifetime = ini_get('session.gc_maxlifetime');
			return true;
		}

		public function read($id){
			$tmp = $_SESSION;
			$_SESSION = json_decode($this->memcache->get("memc.sess.key.{$id}"),true);
			if(isset($_SESSION) && !empty($_SESSION) && $_SESSION != null){
				$new_data = session_encode();
				$_SESSION = $tmp;
				return $new_data;
			}else{
				return "";
			}
		}

		public function write($id, $data){
			$tmp = $_SESSION;
			session_decode($data);
			$new_data = $_SESSION;
			$_SESSION = $tmp;
			return $this->memcache->set("memc.sess.key.{$id}", json_encode($new_data), 0, $this->lifetime);
		}

		public function destroy($id){
			return $this->memcache->delete("memc.sess.key.{$id}");
		}

		public function gc(){
			return true;
		}

		public function close(){
			return true;
		}
	}


	$identSession=substr($_COOKIE["connect_sid"],2);
	$identSession=explode(".",$identSession);
	session_id($identSession[0]);
	$reste="";
	$sident="valeurVide";
	foreach( $identSession as $key => $val ){
		if($key==0){
			$sident=$val;
		}else{
			$reste.=$val;
		}
	}
	$sidCrypt=hash_hmac('sha256',$sident,'1234567890Cl@ranet3575QWERTY',true);
	$sidCrypt=base64_encode($sidCrypt);
	$sidCryptSansReplace=$sidCrypt;
	$sidCrypt=ereg_replace("=+$","",$sidCrypt);

	$connectOk=($reste===$sidCrypt);
	if($connectOk){
		session_id($sident);
		new memcacheSessionHandler();
	}
?>
