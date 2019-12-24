<?php
	session_start();

	if (isset($_POST['src']) && $_SESSION['csrf_token'] && $_SESSION['csrf_token'] == $_POST['csrf_token']) {

		include_once('config/config.php');
		$src = $_POST['src'];

		function deleteImg($src)
		{	
			global $con;

			$query = $con->prepare("DELETE FROM images WHERE src = :src");

			$query->bindParam(':src', $src);
			$query->execute();
		}

		deleteImg($src);
	}
	else{
		echo "<p style='color:red;'>Access denied. Error 403</p>";
	}