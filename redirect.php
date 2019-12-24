<?php 
	session_start();
	include('helpers/url_helpers.php');
// -------------------------------
	function getUrlClickValue($url)
	{
		global $con;

		$query = $con->prepare("SELECT * FROM sites WHERE url = :url");

		$query->bindParam(':url', $url);
		$query->execute();
		$row = $query->fetch(PDO::FETCH_ASSOC);
		return $row['clicks'];
	}

	function updateUrlClicks($url)
	{
		global $con;

		$clicks = getUrlClickValue($url)+1;

		$query = $con->prepare("UPDATE sites SET clicks = :clicks WHERE url = :url");

		$query->bindParam(':clicks', $clicks);
		$query->bindParam(':url', $url);
		$query->execute();

		header('location:' . $url);
	}

// -------------------------------

	if (isset($_GET['url']) && isset($_GET['token']) && isset($_SESSION['token'])) {

		if ($_SESSION['token'] == $_GET['token']) {
			
			include('config/config.php');
			updateUrlClicks($_GET['url']);
		}
		else{
			echo "Invalid token " . $_GET['token'];
		}	
	}
	else{
		
		include('errors/404.php');
		exit();
	}

?>