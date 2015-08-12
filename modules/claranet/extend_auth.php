<?php
/*****************************/
/*                           /*
/*                           /*
/*                           /*
/*****************************/
if(isset($_SESSION['user'])) {
	if (isset($_SESSION['profile']) && ($_SESSION['profile']=='admin')) {
		$this->user = isset($_SESSION['user']) ? 'staff' : '';
		$this->passwd = isset($_SESSION['user']) ? 'staff' : '';
	} else if(isset($_SESSION['profile']) && ($_SESSION['profile']=='staff')) {
		$this->user = isset($_SESSION['user']) ? 'staff' : '';
		$this->passwd = isset($_SESSION['user']) ? 'staff' : '';
	} else{
		$this->user = isset($_SESSION['user']) ? 'guest' : '';
		$this->passwd = isset($_SESSION['user']) ? 'guest' : '';
	}
	
	$component='dashboard';
	$try_auth=True;
}

