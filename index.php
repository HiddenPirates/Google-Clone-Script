<?php include('helpers/url_helpers.php');?>

<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=project_url('/assets/images/icon/icon.png');?>">

    <script type="text/javascript" src="<?=project_url('//assets/js/jquery/jquery-3.4.1.slim.min.js');?>"></script>

    <link rel="stylesheet" type="text/css" href="<?=project_url('/assets/css/index-page.css');?>">
    <link rel="stylesheet" type="text/css" href="<?=project_url('/assets/css/index-mediaquery.css');?>">
    <link rel="stylesheet" type="text/css" href="<?=project_url('/assets/fonts/fontawesome/css/all.css');?>">

    <title>Voogle</title>
  </head>
  <body>

  	<nav>
  		<ul id="menu-items">
  			<a href="images"><li>Images</li></a>
  		</ul>
  		<span id="show-menu"><i class="fas fa-bars"></i></span>
  	</nav>

  	<div class="menu-container">
  		<span id="hide-menu">&times;</span>

  		<div>
  			<ul>
  				<li>
		            <a href="http://facebook.com/nuralam543210">
		              <button class="contact-btn">
		                <i class="fab fa-facebook-square"></i> Facebook
		              </button>
		            </a>
		        </li>
		        <li>
		            <a href="http://youtube.com/c/jiboncare">
		              <button class="contact-btn">
		                <i class="fab fa-youtube"></i> YouTube
		              </button>
		            </a>
		        </li>
		        <li><a href="http://tenminit.com">
		              <button class="contact-btn">
		                <i class="fas fa-globe-asia"></i> Website
		              </button>
		            </a>
		        </li>
		        <li>
		        	<a href="submit-url">Submit Url To Crawl</a>
		        </li>
  			</ul>
  		</div>
  	</div>

  	<div class="logo-div" oncontextmenu="return false">
  		<img src="<?=project_url('/assets/images/logo/logo.png');?>" width="100%">
  	</div>
  	<div class="site-name">
  		<span style="color: blue;">V</span><span style="color:red;">o</span><span style="color:orange;">o</span><span style="color:blue;">g</span><span style="color:green;">l</span><span style="color:red;">e</span>
  	</div>

  	<form action="search" method="get">
  		<div class="search-bar-div">
  			<div class="input-box-div">
  				<input type="text" name="q" class="input-box" placeholder="What's on your mind...">
  			</div>
  			<div class="search-btn-div">
  				<button class="search-btn" type="submit"><i class="fas fa-search"></i></button>
  			</div>
  		</div>
  		<input type="hidden" name="search" value="web">
  	</form>




<script type="text/javascript">

	$('.input-box').focusin(function(){
		$('.search-bar-div').css({
			'box-shadow':'0px 1px 4px 1px #3d5faf',
			'border':'none'
		});
	});

	$('.input-box').focusout(function(){
		$('.search-bar-div').css({
			'box-shadow':'0px 1px 4px 1px #888888',
		});
	});
	$('.input-box').focusin(function(){
		$('.search-btn').css({
			'color':'#3d5faf',
			// 'border':'none'
		});
	});

	$('.input-box').focusout(function(){
		$('.search-btn').css({
			'color':'#888888',
		});
	});



	$('#show-menu').click(function(){
		$('.menu-container').css({

			'width':'250px',
			'background':'#fafafa',
			'box-shadow':'0px 0px 10px 2px #888888'

		});

		$('#menu-items').css({'display':'none'});
		$('#show-menu').css({'display':'none'});
	});

	$('#hide-menu').click(function(){
		$('.menu-container').css({

			'width':'0px',
			'background':'none',
			'box-shadow':'none'

		});

		$('#menu-items').css({'display':'block'});
		$('#show-menu').css({'display':'block'});
	});
</script>

<?php include('layout/footer.php');?>