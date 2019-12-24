<?php

function getWebResults($search_query)
{
	global $con;
	$resultsArray = array();

	$words = explode(" ", $search_query);

	$query = $con->prepare("SELECT * FROM sites WHERE title LIKE :search_query 
							OR description LIKE :search_query 
							OR keywords LIKE :search_query 
							OR url LIKE :search_query 
							ORDER BY clicks DESC");

	$search_query = '%' . $search_query . '%';
	$query->bindParam(':search_query', $search_query);
	$query->execute();

	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$resultsArray[] = $row;
	}

	foreach ($words as $word) {
		
		$query = $con->prepare("SELECT * FROM sites WHERE title LIKE :search_query 
							OR description LIKE :search_query 
							OR keywords LIKE :search_query 
							OR url LIKE :search_query 
							ORDER BY clicks DESC");

		$word = '%' . $word . '%';
		$query->bindParam(':search_query', $word);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$resultsArray[] = $row;
		}
	}	

	$resultsArray = array_unique($resultsArray, SORT_REGULAR);

	echo '
		<div class="founds-number-div">
			About ' . sizeof($resultsArray) . ' results found
		</div>
	';

	if (empty($resultsArray)) {

		echo '
			<div class="results-div">
				<h1> No results found :(</h1>
			</div>
		';
	}
	else{

		return $resultsArray;
	}	
}

// ---------------------------------------------------------------------------

function getImageResults($search_query)
{
	global $con;
	$resultsArray = array();

	$words = explode(" ", $search_query);

	$query = $con->prepare("SELECT * FROM images WHERE alt LIKE :search_query 
							OR title LIKE :search_query 
							OR src LIKE :search_query 
							OR site_url LIKE :search_query ORDER BY clicks DESC");

	$search_query = '%' . $search_query . '%';
	$query->bindParam(':search_query', $search_query);
	$query->execute();

	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$resultsArray[] = $row;
	}

	foreach ($words as $word) {
		
		$query = $con->prepare("SELECT * FROM images WHERE alt LIKE :search_query 
								OR title LIKE :search_query 
								OR src LIKE :search_query 
								OR site_url LIKE :search_query ORDER BY clicks DESC");

		$word = '%' . $word . '%';
		$query->bindParam(':search_query', $word);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$resultsArray[] = $row;
		}
	}	

	$resultsArray = array_unique($resultsArray, SORT_REGULAR);

	echo '
		<div class="founds-number-div">
			About ' . sizeof($resultsArray) . ' results found
		</div>
	';

	if (empty($resultsArray)) {

		echo '
			<div class="results-div">
				<h1> No image found :(</h1>
			</div>
		';
	}
	else{

		return $resultsArray;
	}
}