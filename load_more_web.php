<?php
session_start();

include('helpers/url_helpers.php');

if (isset($_SESSION['resultsArraySession'])) {
		
	if (isset($_POST['csrf_token'])) {

		if ($_POST['csrf_token'] == $_SESSION['csrf_token']) {
			
			$counter = 0;

			foreach ($_SESSION['resultsArraySession'] as $result) {

				if($counter < 20){

					$url = project_url('redirect.php?token=') .  $_SESSION['token'] . "&url=" . $result['url'];
						echo '
							<div class="results-div">
							 <a href="'.$url.'" class="title-link">
							 	<div class="title">
							 	'.
							 		$result['title']
							 	.'
							 	</div>
							 </a>
							 <a href="'.$url.'">
							 	<div class="website">
							 		'.
							 			$result['url']
							 		.'
							 	</div>
							 </a>

							 <div class="web-description">
							 	 '.
							 		$result['description']
							 	.'
							 </div>
							</div>
						';
				}

				$counter++;
			}

			$_SESSION['resultsArraySession'] = array_slice($_SESSION['resultsArraySession'], 20);
		}
		else{
			echo "Invalid token";
		}

		
	}
	else{
		header('location:' . project_url());
	}

	
}
else{
	header('location:' . project_url());
}