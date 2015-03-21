<!DOCTYPE html>
<html>
<head>
	<title>Swift Bot</title>
	<style type="text/css">
		body{
			padding-top: 20px;
		}
		.crawl{
			width: 800px;
		}
	</style>
	<script src="assets/jquery-2.1.0.min.js"></script>
	<script type="text/javascript">
		$(document).on("click", "#crawl", function () {
			var url = $('#url').val();
			$(".status").html('<center><img src="assets/ajax.gif" alt="Crawling...."></center>');
			$.ajax({
			    url: 'item.php',
			    type: 'POST',
			    data: {url:url},
			    success: function(data){
			    	$(".status").html('');
			    	$(".status").html(data);
			    	var r=confirm("Process Completed. Continue Other");
			    	if (r==true){
			    		location.reload();
			    	} else{
			    		console.log("Thanks!!");
			    	}
			    }
			});
		});
	</script>
</head>
<body>
<center>
<div class="crawl">
	<img src="assets/bot.jpg" style="width:50px;">
	<input type="url" id="url" style="width: 400px;" autofocus="" autosuggest="" placeholder="Enter any URL">
	<button type="submit" id="crawl">Crawl</button>
</div>
</center>
<hr>
<div class="status"></div>
</body>
</html>