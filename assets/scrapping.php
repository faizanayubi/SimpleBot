<?php
	$url = 'http://c0028545.cdn1.cloudfiles.rackspacecloud.com/new3305-82-thumb.jpg';
	$img = 'new/pic2.jpg';
	file_put_contents($img, file_get_contents($url));
?>