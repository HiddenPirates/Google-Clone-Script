<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=project_url('assets/images/icon/icon.png');?>">

    <script type="text/javascript" src="<?=project_url('/assets/js/jquery/jquery-3.4.1.slim.min.js');?>"></script>
    <script type="text/javascript" src="<?=project_url('/assets/js/jquery/jquery.js');?>"></script>
    <script type="text/javascript" src="<?=project_url('assets/js/fancybox/dist/jquery.fancybox.min.js');?>"></script>

    <link rel="stylesheet" type="text/css" href="<?=project_url('assets/css/search.css');?>">
    <link rel="stylesheet" type="text/css" href="<?=project_url('assets/css/media-query.css');?>">
    <link rel="stylesheet" type="text/css" href="<?=project_url('assets/fonts/fontawesome/css/all.css');?>">
    <link rel="stylesheet" type="text/css" href="<?=project_url('assets/js/fancybox/dist/jquery.fancybox.min.css');?>">

    <title><?=$_GET['q'];?> - Voogle Search</title>
  </head>
  <body>

  	<nav>

  		<div class="nav-parent-div1">
  			
	  		<div class="logo-div">
	  			<a href="<?=project_url();?>"><img src="<?=project_url('/assets/images/logo/logo.png');?>" width="100%"></a>
	  		</div>

	  		<div class="site-name">
	  			<label><a href="<?=project_url();?>" style="text-decoration: none;">
	  			<span style="color: blue;">V</span><span style="color:red;">o</span><span style="color:orange;">o</span><span style="color:blue;">g</span><span style="color:green;">l</span><span style="color:red;">e</span>
		  		</label></a>
		  	</div>


		  	<?php
		  		$current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		  		$url_components = parse_url($current_url);
		  		parse_str($url_components['query'], $params); 

		  		$q = $params['q'];
		  		$q = str_replace(" ", "+", $q);

		  		$search = $params['search'];
		  	?>


	  		<form action="search" method="get">
		  		<div class="search-bar-div">
		  			<div class="input-box-div">
		  				<input type="text" name="q" class="input-box" value="<?=$_GET['q'];?>" placeholder="What's on your mind...">
		  			</div>
		  			<div class="search-btn-div">
		  				<button class="search-btn" type="submit"><i class="fas fa-search"></i></button>
		  			</div>
		  			<input type="hidden" name="search" value="<?=$search;?>">
		  		</div>
		  	</form>
	  	</div>


	  	<div class="nav-parent-div2">
	  		<ul>
	  			<a href="<?=project_url("search?q=$q&search=web");?>" id="web"><li> <i class="fas fa-globe-asia"></i> Web</li></a>
	  			<a href="<?=project_url("search?q=$q&search=images");?>" id="images"><li> <i class="fas fa-camera"></i> Images</li></a> 
	  		</ul>
	  	</div>


  	</nav>

  	
