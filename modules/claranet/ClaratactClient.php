<?php
	class ClaratactClient{
		
		public function getServeurForProject($id_prj){
			$curl = curl_init();
	
	        curl_setopt($curl, CURLOPT_URL, CLARATACT_WS."/REST/Projet/getProjectHosts.php");
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($curl, CURLOPT_POST, true);

	        $postfields=array('login'=>CLARATACT_USER,'pass'=>CLARATACT_PASS,'idProjet'=>$id_prj);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
	
	        $return=curl_exec($curl);
	
	        curl_close($curl);
	        
			return json_decode($return);
		}

		public function getIdPrjFromHostname($hostname){
			$curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, CLARATACT_WS."/REST/host/getProjectId.php");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);

            $postfields=array('login'=>CLARATACT_USER,'pass'=>CLARATACT_PASS,'hostname'=>$hostname);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);

            $return=curl_exec($curl);

            curl_close($curl);

			
            return $return;
		} 
		
		public function getAllProject($host=''){
			$curl = curl_init();
			
			curl_setopt($curl, CURLOPT_URL, CLARATACT_WS."/REST/contact/getProjectsForStaff.php");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			
			$postfields=array('login'=>CLARATACT_USER,'pass'=>CLARATACT_PASS,'host'=>$host);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
			
			$return=curl_exec($curl);
			
			curl_close($curl);
			
			return $return;
		}
	}

?>
