<?php
ob_start();

if (!isset($_POST['url'])) {
	die('Re enter your url');
}

include('classes/parser.php');
include('config/config.php');

$url = $_POST['url'];

$alreadyCrawled = array();
$crawling = array();
$alreadyFoundImages = array();

function checkExitsLink($url)
{
	global $con;

	$query = $con->prepare("SELECT * FROM sites WHERE url = :url");

	$query->bindParam(':url', $url);
	$query->execute();

	return $query->rowCount() != 0;
}

function checkExitsImages($src)
{
	global $con;

	$query = $con->prepare("SELECT * FROM images WHERE src = :src");

	$query->bindParam(':src', $src);
	$query->execute();

	return $query->rowCount() != 0;
}

function insertLink($url,$title,$description,$keywords,$clicks=0)
{
	global $con;

	$query = $con->prepare("INSERT INTO sites (url, title, description, keywords, clicks)
    						VALUES (:url, :title, :description, :keywords, :clicks)");

    $query->bindParam(':url', $url);
    $query->bindParam(':title', $title);
    $query->bindParam(':description', $description);
    $query->bindParam(':keywords', $keywords);
    $query->bindParam(':clicks', $clicks);

    return $query->execute();
}

function insertImages($src,$site_url,$alt,$title = "")
{
	global $con;
	$clicks = 0;

	$query = $con->prepare("INSERT INTO images(src, site_url, alt, title, clicks) 
							VALUES (:src,:site_url,:alt,:title, :clicks)");

    $query->bindParam(':src', $src);
    $query->bindParam(':site_url', $site_url);
    $query->bindParam(':alt', $alt);
    $query->bindParam(':title', $title);
    $query->bindParam(':clicks', $clicks);

    return $query->execute();
}

function createLink($href,$url)
{	
	$scheme = parse_url($url)['scheme']; // http or https
	$host = parse_url($url)['host']; // www.w3schools.com

	if (substr($href, 0, 2) == "//") {
		$href = "http" . ":" . $href; 
	}
	else if (substr($href, 0, 1) == "/") {
		$href = $scheme . "://" . $host . $href; 
	}
	else if (substr($href, 0, 3) == "../") {
		$href = $scheme . "://" . $host . "/" . $href; 
	}
	else if (substr($href, 0, 2) == "./") {
		$href = $scheme . "://" . $host . dirname(parse_url($url)['path']) . substr($href, 1); 
	}
	else if ((substr($href, 0, 5) != "https") && (substr($href, 0, 4) != "http")) {
		$href = $scheme . "://" . $host . "/" . $href; 
	}

	return $href;
}

function createImageLink($href,$url)
{	
	$scheme = parse_url($url)['scheme']; // http or https
	$host = parse_url($url)['host']; // www.w3schools.com
	
	if (isset(parse_url($url)['path'])) {
		$path = dirname(parse_url($url)['path']);
	}
	

	if (substr($href, 0, 2) == "//") {
		$href = "http" . ":" . $href; 
	}
	else if (substr($href, 0, 1) == "/") {
		$href = $scheme . "://" . $host . $href; 
	}
	else if (substr($href, 0, 3) == "../") {
		$href = $scheme . "://" . $host . @$path . "/" . $href; 
	}
	else if (substr($href, 0, 2) == "./") {
		$href = $scheme . "://" . $host . dirname(parse_url($url)['path']) . substr($href, 1); 
	}
	else if ((substr($href, 0, 5) != "https") && (substr($href, 0, 4) != "http")) {
		$href = $scheme . "://" . $host . @$path . "/" . $href; 
	}

	return $href;
}

function getDetails($url)
{	
	global $alreadyFoundImages;

	$parser = new DomDocumentParser($url);
	$titleArray = $parser->getTitleTag();
	$metaArray = $parser->getMeta();
	// $keywordsArray = $parser->getKeywords();

	if ((sizeof($titleArray) == 0) ||  ($titleArray->item(0) == NULL)) {
		return;
	}

	$title = $titleArray->item(0)->nodeValue;
	$title = str_replace("\n", "", $title);

	if ($title == "") {
		return;
	}

	$description = "";
	$keywords = "";

	$src = "";
	$alt = "";

	foreach ($metaArray as $meta) {

		if (strcasecmp($meta->getAttribute('name'),"description") == 0) {
			$description = $meta->getAttribute('content');
		}

		if (strcasecmp($meta->getAttribute('name'),"keywords") == 0) {
			$keywords = $meta->getAttribute('content');
		}
	}

	$description = str_replace("\n", "", $description);
	$keywords = str_replace("\n", "", $keywords);

	if (!checkExitsLink($url)) {
		insertLink($url,$title,$description, $keywords);
		echo "SUCCESS! <br>";
	}

	$imagesArray = $parser->getImages();

	foreach ($imagesArray as $image) {

		$src = $image->getAttribute('src');
		$alt = $image->getAttribute('alt');

		$src = createImageLink($src,$url);

		if (!in_array($src, $alreadyFoundImages)) {

			$alreadyFoundImages[] = $src;

			if (!checkExitsImages($src)) {

				if (@getimagesize($src)) {

					insertImages($src,$url,$alt,$title);
					echo "insert <br>";
				}
			}
		}
	}
}

function followLinks($url)
{
	global $alreadyCrawled;
	global $crawling;

	$parser = new DomDocumentParser($url);
	$links = $parser->getLinks();

	foreach ($links as $link) {

		$href = strtolower($link->getAttribute('href'));

		if (substr($href,0,1) == "#") {
			continue;
		}
		elseif (substr($href,0,11) == "javascript:") {
			continue;
		}

		$href = createLink($href, $url);

		if (!in_array($href, $alreadyCrawled)) {
			
			$alreadyCrawled[] = $href;
			$crawling[] = $href;

			getDetails($href);
		}
		else{
			continue;
		}
	}

	array_shift($crawling);

	foreach ($crawling as $site) {
		followLinks($site);
	}
}



followLinks($url);
