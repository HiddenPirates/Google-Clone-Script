<?php
session_start(); 
include('helpers/url_helpers.php');
include('layout/header.php');
include('config/config.php');
include('helpers/search_helpers.php');

// -------------------------------------------------------------
if (!isset($_GET['q']) || $_GET['q']==NULL) {
	header("location:" . project_url());
}
// -------------------------------------------------------------
if (isset($_GET['search'])) {

	if ($_GET['search'] == 'images') {
		echo "
			<script type='text/javascript'>
				$('#images').css({
					'color':'#007bff',
					'border-bottom':'3px solid #1a73e8'
				});
			</script>
		";
	}
	else{
		echo "
			<script type='text/javascript'>
				$('#web').css({
					'color':'#007bff',
					'border-bottom':'3px solid #1a73e8'
				});
			</script>
		";
	}
}
else{
	echo "
		<script type='text/javascript'>
			$('#web').css({
				'color':'#007bff',
				'border-bottom':'3px solid #1a73e8'
			});
		</script>
		";
}
// -------------------------------------------------------------

?>






<div class="container">
	<!-- results -->
	<div class="result-showing-div">

	<?php
		$search_query = $_GET['q'];

		if ($_GET['search'] == 'images') {

			$resultsArray = getImageResults($search_query);

			if (isset($resultsArray)) {

				$counter = 0;

				foreach ($resultsArray as $result) {

					if($counter < 50){

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

				$_SESSION['resultsArraySession'] = array_slice($resultsArray, 50);

				echo '
					</div>
					<div class="load-more-div">
						<button class="load-more-btn" id="load-image-btn"> <i class="fas fa-angle-double-down"></i> Load More </button>
					</div>
				';
			}
		}
		else{

			$resultsArray = getWebResults($search_query);

			if (isset($resultsArray)) {

				$_SESSION['token'] = md5(uniqid());
				$counter = 0;

				foreach ($resultsArray as $result) {

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

				$_SESSION['resultsArraySession'] = array_slice($resultsArray, 20);

				echo '
					</div>
					<div class="load-more-div">
						<button class="load-more-btn" id="load-web-btn"> <i class="fas fa-angle-double-down"></i> Load More </button>
					</div>
				';
			}
		}
	?>

</div>

<?php

	$_SESSION['csrf_token'] = md5(uniqid());
?>

<script>
	$('#load-web-btn').click(function(){

		var csrf_token = '<?=$_SESSION['csrf_token'];?>';

		$.ajax({
			type: "POST",
			url: 'load_more_web.php',
			data: {csrf_token:csrf_token},
			success:function(data,status){
				$(".result-showing-div").append(data);
				// alert(data);
			}
			
		});
	});



	$('#load-image-btn').click(function(){

		var csrf_token = '<?=$_SESSION['csrf_token'];?>';

		$.ajax({
			type: "POST",
			url: 'load_more_images.php',
			data: {csrf_token:csrf_token},
			success:function(data,status){
				$(".result-showing-div").append(data);
				// alert(data);
			}
			
		});
	});


</script>


<script type="text/javascript">
	
	$("[data-fancybox]").fancybox({

		caption : function( instance, item){
			var caption = $(this).data('caption') || '';
			var siteUrl = $(this).data('siteurl') || '';

			if (item.type == 'image') {
				 caption = (caption.length ? caption + '<br><br>' : '') + '<a href="' + item.src + '"> View Image </a><br>'
				 + '<a href="' + siteUrl + '"> Visit This Website </a>';
			}

			return caption;
		},

		afterShow : function(instance, item){
			var csrf_token = '<?=$_SESSION['csrf_token'];?>';
			var src = item.src;

			$.ajax({
				type: "POST",
				url: 'update-image-clicks.php',
				data: { csrf_token : csrf_token,
						src : src},
				success:function(data,status){
					
				}
			});
		}
	});
</script>


<script type="text/javascript">
	$("img").on("error", function () {
	    // $(this).attr("src", "broken.gif");
	    var parent1 = $(this).parent();
	    var parent2 = parent1.parent();
	    parent2.parent().css({"display": "none"});

	    var csrf_token = '<?=$_SESSION['csrf_token'];?>';
		var src = $(this).attr("src");

	    $.ajax({
	    	type: "POST",
			url: 'delete-broken-images.php',
			data: { csrf_token : csrf_token,
					src : src},
			success:function(data,status){
					
			}
	    });
	    // parent2.parent().css({"border": "1px solid red"})
	});

	$('.input-box').focusin(function(){
		$('.search-bar-div').css({
			'box-shadow':'0px 1px 4px 1px #888888',
			'border':'none'
		});
	});

	$('.input-box').focusout(function(){
		$('.search-bar-div').css({
			'box-shadow':'0px 0px 2px 1px lightgrey',
		});
	});
</script>

<?php include('layout/footer.php');?>