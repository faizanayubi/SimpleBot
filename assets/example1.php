<?php
	include_once('simple_html_dom.php');
	
	$html = file_get_html('http://www.mobilepriceindia.co.in/price-list/samsung');

	foreach($html->find('div.price-list-element') as $mobile) {
		$item['name']     = $mobile->find('a', 0)->plaintext;
		$item['cost']    = $mobile->find('div.pricelistprice', 0)->plaintext;
		$mobiles[] = $item;
	}

	echo '<pre>', print_r($mobiles), '</pre>';
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>df</title>
</head>
<body>
<table>
	<tr align="center">
		<td width="141px" valign="top">
			<div class="item">
				<a href="http://www.mysmartprice.com/mobile/nokia-lumia-1520-msp3305">
					<img src="http://c0028545.cdn1.cloudfiles.rackspacecloud.com/new3305-82-thumb.jpg" alt="Nokia Lumia 1520" title="Nokia Lumia 1520">
				</a>
				<div class="item_title">
				<table>
					<tr align="center">
						<td height="35px" valign="center">
							<a href="http://www.mysmartprice.com/mobile/nokia-lumia-1520-msp3305">
								Nokia Lumia 1520
							</a>
						</td>
					</tr>
				</table>
				</div>
				<div class="price">
					<b>
						<span class="WebRupee">Rs.</span> 44,859
					</b>
				</div>
			</div>
		</td>
</body>
</html>