<?php
session_start();

include('helpers/url_helpers.php');

if (isset($_SESSION['resultsArraySession'])) {
		
	if (isset($_POST['csrf_token'])) {

		if ($_POST['csrf_token'] == $_SESSION['csrf_token']) {
			
			$counter = 0;

			foreach ($_SESSION['resultsArraySession'] as $result) {

				if($counter < 30){

					$host = parse_url($result['site_url'])['scheme'] . "://" . parse_url($result['site_url'])['host'];

					    echo '
				 			<div class="image-card">
				 				<a href="' . $result['src'] . '" data-fancybox="gallery" data-caption="' . $result['title'] . '" data-siteurl="' .$result['site_url']. '">
				 					<div class="image-div">
				 						<img src="' . $result['src']  . '">
				 					</div>
				 				</a>
				 				<a href="' . $result['site_url'] . '">
				 					<div class="img-title">' . $result['title'] . '</div>
				 				</a>
				 				<a href="' . $host . '">
				 					<div class="base-url">' . $host . '</div>
				 				</a>
				 			</div>
				 		';
				}

				$counter++;
			}

			$_SESSION['resultsArraySession'] = array_slice($_SESSION['resultsArraySession'], 30);
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