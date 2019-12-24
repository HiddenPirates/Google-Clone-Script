<?php
	session_start();

	if (isset($_POST['src']) && $_SESSION['csrf_token'] && $_SESSION['csrf_token'] == $_POST['csrf_token']) {

		include_once('config/config.php');
		$src = $_POST['src'];

		function getClicks($src)
		{	
			global $con;

			$query = $con->prepare("SELECT * FROM images WHERE src = :src");

			$query->bindParam(':src', $src);
			$query->execute();
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return $row['clicks'];
		}

		function updateClicks($src)
		{	
			global $con;
			
			$clicks = getClicks($src)+1;
			$query = $con->prepare("UPDATE images SET clicks = :clicks WHERE src = :src");

			$query->bindParam(':clicks', $clicks);
			$query->bindParam(':src', $src);
			$query->execute();
		}

		updateClicks($src);
	}
	else{
		echo "<p style='color:red;'>Access denied. Error 403</p>";
	}