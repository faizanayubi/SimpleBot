<?php
	
	set_time_limit(24*60*60);
	mysql_connect('localhost', 'root', '');
	mysql_select_db('test');
	include_once('simple_html_dom.php');
	require_once 'model/initialize.php';
	
	if(isset($_POST['url'])){
		$count = 0;
		$url = $_POST['url'];

		$html = file_get_html($url);

		$start = microtime(true);
		foreach($html->find('a') as $item) {
			if($count>12){
				$url = $item->href;
				$mobile_url = "http://www.mysmartprice.com/product/mobile/".substr($url, 35)."-other#techspec<br>";
				$furl = str_replace("msp", "mst", $mobile_url);
				mobile_details($furl);
			}
			$count++;
			
		}
		$end = number_format((microtime(true) - $start), 3);
		echo "{$count} items took {$end} seconds";
	}

	function mobile_details($url){
		$time = strftime("%Y-%m-%d %H:%M:%S", time()+60*60*5);
		$count = 0;

		$html = file_get_html($url);

		
		//Mobile Details
		$details = "";
		foreach($html->find('div.item_details') as $spec) {
			$details .= $spec->innertext;
		}
		//echo $details;
		
		//Features
		$features = "";
		foreach($html->find('div.abt_text ul li') as $spec) {
			$features .= "<p>".$spec->innertext."<p>";
		}
		//echo $features;

		
		//Specification
		$specification = "";
		foreach($html->find('div.section-heading table tbody') as $spec) {
			$specification .= $spec->innertext;
		}
		//echo $specification;

		//item name
		$name = $html->find('span[itemprop=name]', 0)->plaintext;

		//item rating
		$rating = $html->find('span[itemprop=ratingValue]', 0)->plaintext;

		//item price
		$price = $html->find('.price_val', 0)->plaintext;
		$price_val = str_replace(",", "", $html->find('.price_val', 0)->plaintext);

		//image
		$image_link = $html->find('img[id=mspSingleImg]', 0)->src;
		$image_name = substr($image_link, 51);

		$product = new Product();
		$product->category_id = '1';
		$product->manufacturer_id = '1';
		$product->name = $name;
		$product->market_price = $price_val;
		$product->short_desc = $features;
		$product->spec = $specification;
		$product->long_desc = $details;
		$product->created = $time;
		$product->crawled = $time;
		if($product->save()){
			$photo = new Photograph();
			$photo->filename = $image_name;
			$photo->created = $time;
			if($photo->save()){
				file_put_contents('images/'.$image_name, file_get_contents($image_link));
				$image = new Image();
				$image->photo_id = $photo->id;
				$image->user_id = 1;
				$image->property_id = $product->id;
				$image->property = 'item';
				if($image->save()){
					echo $name."	...Done<br>";
				}
			}
		}
	}
?>