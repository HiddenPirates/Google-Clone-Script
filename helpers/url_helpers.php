<?php

function project_url($path = NULL)
{	
	if (substr($path,0,1) == "/") {
		$path = substr_replace($path,"",0,1);
	}
	return "http://".$_SERVER['HTTP_HOST'] . "/voogle" . "/" . $path;
}

// --------------------------------------------------------------

