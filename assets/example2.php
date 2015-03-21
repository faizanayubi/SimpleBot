<?php
	mysql_connect('localhost', 'root', '');
	mysql_select_db('data');
	include_once('simple_html_dom.php');
	if(isset($_GET['url'])){
		$count = 0;
		$url = $_GET['url'];
		$brand = substr($url, 45, strlen($url));
		$html = file_get_html($url);
		foreach($html->find('div.price-list-element') as $mobile) {
			$image = $mobile->find('img', 0)->src."<br>";
			$item = str_replace("-", " ", substr($mobile->find('a', 0)->href, 47, strlen($mobile->find('a', 0)->href)));
			$price = substr($mobile->find('div.pricelistprice', 0)->plaintext, 10, strlen($mobile->find('div.pricelistprice', 0)->plaintext));
			$result = mysql_query("INSERT INTO mobile(name, price, image, brand) VALUES('{$item}', '{$price}', '{$image}', '{$brand}')");
			$count++;
		}
		if($result){ echo "Inserted ".$count." rows";}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Swift Bot</title>
</head>
<body>
<form method="GET" action="index.php">
	<input type="url" name="url">
	<input type="submit" value="Crawl">
</form>
</body>
</html>