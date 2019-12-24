<!DOCTYPE html>
<html>
<head>
	<title>Submit Your Website</title>
	<link rel="icon" type="image/png" href="assets/images/icon/icon.png">
	<style type="text/css">

		html, body{
			padding: 0;
			margin: 0;
			font-family: sans-serif;
		}
		.logo-container{
			width: 130px;
			position: absolute;
			left: 50%;
			top: 10%;
			transform: translate(-50%);
		}
		.form-container{
			position: absolute;
			top: 40%;
			left: 50%;
			transform: translate(-50%);
			padding: 5px 40px 35px 40px;
			box-shadow: 0px 0px 5px 2px lightgrey;
		}
		h1{
			font-weight: bold;
			text-align: center;
		}
		.input-group{
			width: 700px;
			height: 35px;
			display: flex;
			border: 2px solid #19d135;
		}
		.input-container{
			width: 85%;
			box-sizing: border-box;
		}
		.button-container{
			width: 15%;
			box-sizing: border-box;
			background-color:  #19d135;
		}
		#url-input{
			width: 100%;
			height: 100%;
			box-sizing: border-box;
			background: transparent;
			border: none;
			padding: 0px 10px;
			font-style: italic;
		}
		#submit-btn{
			width: 100%;
			height: 100%;
			box-sizing: border-box;
			background: transparent;
			border: none;
			color: #fff;
			font-weight: bold;
			font-size: 15px;
			cursor: pointer;
		}
		.button-container:active{
			background: lightgreen;
		}
		#error-massege{
			color: red;
			width: 100%;
			box-sizing: border-box;
			font-size: 12px;
			padding: 2px;
		}
		.console{
			position: absolute;
			width: 705px;
			top: 65%;
			left: 50%;
			transform: translate(-50%);
			padding: 5px 40px 10px 40px;
			max-height: 150px;
			overflow: auto;
			box-shadow: inset 0px 0px 100px 2px lightgrey;
			-webkit-user-select: none; /* Safari */        
			-moz-user-select: none; /* Firefox */
			-ms-user-select: none; /* IE10+/Edge */
			user-select: none; /* Standard */
		}
	/*------------------------------------------*/

		.loader-div{
			margin: auto;
			width: 100%;
			height: 100vh;
			border: 1px solid lightgrey;
			position: relative;
			background: transparent;
			background-color: rgba(0, 0, 0, 0.6);
		}
		.loaders-container{
			animation: spin 2s linear infinite;
			position: absolute;
			top: 50%;
			left: 50%;
			-ms-transform: translateX(-50%) translateY(-50%);
			-webkit-transform: translate(-50%,-50%);
			transform: translate(-50%,-50%);
		}
		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}
		.loader1{
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			width: 60px;
			height: 60px;
  			position: absolute;
			top: 50%;
			left: 50%;
			-ms-transform: translateX(-50%) translateY(-50%);
			-webkit-transform: translate(-50%,-50%);
			transform: translate(-50%,-50%);
		}
		/*.loader2{
			width: 100px;
			height: 100px;
			border: 10px solid blue;
			position: absolute;
			top: 50%;
			left: 50%;
			-ms-transform: translateX(-50%) translateY(-50%);
			-webkit-transform: translate(-50%,-50%);
			transform: translate(-50%,-50%) rotate(45deg);
			border-image: linear-gradient(45deg, red, blue, green, orange);
			border-image-slice: 1;
		}*/

	</style>

	<script type="text/javascript" src="assets/js/jquery/jquery.js"></script>
</head>
<body>
	<div class="logo-container">
		<img src="assets/images/logo/logo.png" width="100%">
	</div>
	<div class="form-container" id="form-container">
		<h1>Submit Your Website or Url</h1>
		<form action="crawler.php" method="post">
			<div class="input-group">
				<div class="input-container">
					<input type="text" id="url-input" name="url" placeholder="Your website address with scheme.. e.g: http://tenminit.com">
				</div>
				<div class="button-container">
					<button id="submit-btn" type="button">Submit</button>
				</div>
			</div>
			<small id="error-massege"></small>
		</form>
	</div>

	<div class="loader-div" id="spinner" oncontextmenu="return false">
		<h1>It will take maximum 20 minute to crawl your website.</h1>
		<div class="loaders-container">
			<div class="loader1"></div>
		</div>
	</div>

	<div class="console" id="console">
		Console: <br>
	</div>

	<script type="text/javascript">

		function validUrl(){

			var url_input = document.getElementById('url-input').value;
			var submit_btn = document.getElementById('submit-btn');

			try{
				var url = new URL(url_input);
				submit_btn.setAttribute("type", "submit");
				document.getElementById('error-massege').innerHTML = "Correct url :)";
				document.getElementById('error-massege').style.color = "green";

			}
			catch(err){
				submit_btn.setAttribute("type", "button");
				document.getElementById('error-massege').innerHTML = "Enter a valid url with http or https... e.g: https://www.w3schools.com";
				document.getElementById('error-massege').style.color = "red";
			}
		}


		$("input").keydown(function(){
		  validUrl();
		});

		$('#submit-btn').hover(function(){
			validUrl();
		});



		var spinner = $('#spinner');
		var submit_console = $('#console');
		var form_container = $('#form-container');

		spinner.hide();
		submit_console.hide();
		form_container.show();
		
		  $('form').submit(function(e) {
		    e.preventDefault();
		    var url = $("#url-input").val();
		    form_container.hide();
		    spinner.show();
		    submit_console.show();

		    $.ajax({
		    	type: 'POST',
			    url: 'crawler.php',
			    dataType:'html',
			    data: { url:url },
			    success:function(data,status){
			    	$('#console').load('crawler.php');
			    }
			  }).done(function(resp) {
			    spinner.hide();
			    form_container.show();
			  });

		  });

	</script>




</body>
</html>