<?php
// Assuming the above tags are at www.example.com
$tags = get_meta_tags('http://ww2.swiftdeal.in/');

// Notice how the keys are all lowercase now, and
// how . was replaced by _ in the key.
echo $tags['author'];       // name
echo $tags['keywords'];     // php documentation
echo $tags['description'];  // a php manual

?>
