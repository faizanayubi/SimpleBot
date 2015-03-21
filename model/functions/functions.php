<?php
	function redirect_to($location) {
		header("Location: {$location}");
		exit();
	}

	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	function isMobile() {
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
			return true;
		else
			return false;
	}
	
	function isFacebook(){
		$httpReferer = $_SERVER['HTTP_REFERER'];
		if($httpReferer == 'https://apps.facebook.com/swiftdeal/') return true;
		else return false;
	}
	
	function detect_mobile(){
		/* detect mobile device*/
		$ismobile = 0;
		$container = $_SERVER['HTTP_USER_AGENT'];

		// A list of mobile devices 
		$useragents = array ('android', 'avantgo', 'Blazer', 'Palm', 'Handspring', 'Nokia', 'Kyocera', 
				'Samsung', 'Motorola', 'Smartphone', 'Windows CE', 'Blackberry', 'WAP', 'SonyEricsson', 
				'PlayStation Portable', 'LG', 'MMP', 'OPWV', 'Symbian', 'EPOC'); 

		foreach ( $useragents as $useragent ) { 
			if(strstr($container,$useragent)) {
				$ismobile = 1;
			} 
		}
		
		return $ismobile;
	}

	function userAgent($ua){
	    $iphone = strstr(strtolower($ua), 'mobile'); //Search for 'mobile' in user-agent (iPhone have that)
	    $android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
	    $windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)

	    function androidTablet($ua){ //Find out if it is a tablet
	        if(strstr(strtolower($ua), 'android') ){//Search for android in user-agent
	            if(!strstr(strtolower($ua), 'mobile')){ //If there is no ''mobile' in user-agent (Android have that on their phones, but not tablets)
	                return true;
	            }
	        }
	    }
	    $androidTablet = androidTablet($ua); //Do androidTablet function
	    $ipad = strstr(strtolower($ua), 'ipad'); //Search for iPad in user-agent
		$kindle = strstr(strtolower($ua), 'kindle'); //Search for iPad in user-agent

	    if($androidTablet || $ipad || $kindle){ //If it's a tablet (iPad / Android / Kindly)
	        return 'tablet';
	    }
	    elseif($iphone || $android || $windowsPhone){ //If it's a phone and NOT a tablet
	        return 'mobile';
	    }
	    else{ //If it's not a mobile device
	        return 'desktop';
	    }
	}

	function refresh() {
		$page = $_SERVER['PHP_SELF'];
		$sec = "10";
		header("Refresh: $sec; url=$page");
	}

	function get_ip() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return $ip_address;
	}

	function hit_counter() {
		$filename = 'logs/count.txt';
		$new = file_exists($logfile) ? false : true;
		$handle = fopen($filename, 'r');
		$count = fread($handle, filesize($filename));
		fclose($handle);
		
		$count_inc = $count + 1;
		
		$handle = fopen($filename, 'w');
		fwrite($handle, $count_inc);
		fclose($handle);
	}
	
	function reding_file(){
		$logfile = '../logs/count.txt';
		if($handle=fopen($logfile, 'r')){
			foreach(file($logfile) as $content){ echo $content;}
		}
	}

	function log_action($type, $action, $message="") {
		$logfile = 'logs/'.$type.'.txt';
		$new = file_exists($logfile) ? false : true;
		if ($handle = fopen($logfile, 'a')) {
			$timestamp = strftime("%Y-%m-%d %H:%M:%S", time()+1800);
			$content = "{$timestamp} | {$action} : {$message}\n";
			fwrite($handle, $content);
			fclose($handle);
			if ($new) { chmod($logfile, 0755);}
		} else {
			echo "Could not open log file for writing";
		}
	}

	function strip_zeros_from_date($marked_string="") {
		//first remove mark zeroes
		$no_zeros = str_replace("*0", "", $marked_string);
		//then remove any remaining marks
		$cleaned_string = str_replace("*", "", $no_zeros);
		return $cleaned_string;
	}

	function output_message($message="") {
		if (!empty($message)) {
			return '<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						'.$message.'
					</div>';
		}elseif(!empty($sessoion->message)) {
			return '<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						'.$session->message.'
					</div>';
		}else {
			return "";
		}
		
	}
/*
	function __autoload($class_name) {
		$class_name = strtolower($class_name);
		$path = "{$class_name}.php";
		if (file_exists($path)) {
			require_once $path;
		} else {
			die("The file {$class_name}.php could not be found...");
		}
	}
*/
	function datetime_to_text($datetime="") {
		$unixdatetme = strtotime($datetime);
		return strftime("%B %d %Y at %I:%M %p", $unixdatetme);
	}

	//Form Functions
	function check_required_fields($required_array) {
		$field_errors = array();
		foreach($required_array as $fieldname) {
			if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
				$field_errors[] = $fieldname; 
			}
		}
		return $field_errors;
	}

	function check_max_field_lengths($field_length_array) {
		$field_errors = array();
		foreach($field_length_array as $fieldname => $maxlength ) {
			if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $field_errors[] = $fieldname; }
		}
		return $field_errors;
	}

	function display_errors($error_array) {
		echo "<p class=\"errors\">";
		echo "Please review the following fields:<br />";
		foreach($error_array as $error) {
			echo " - " . $error . "<br />";
		}
		echo "</p>";
	}
	
	function censor($keywords){
		$swearWords = array('anal', 'anus', 'arse', 'ass', 'ballsack', 'balls', 'bastard', 'bitch', 'biatch', 'bloody', 'blowjob', 'blow job', 'bollock', 'bollok', 'boner', 'boob', 'bugger', 'bum', 'butt', 'buttplug', 'clitoris', 'cock', 'coon', 'crap', 'cunt', 'damn', 'dick', 'dildo', 'dyke', 'fag', 'feck', 'fellate', 'fellatio', 'felching', 'fuck', 'f u c k', 'fudgepacker', 'fudge packer', 'flange', 'Goddamn', 'God damn', 'hell', 'homo', 'jerk', 'jizz', 'knobend', 'knob end', 'labia', 'lmao', 'lmfao', 'muff', 'nigger', 'nigga', 'omg', 'penis', 'piss', 'poop', 'prick', 'pube', 'pussy', 'queer', 'scrotum', 'sex', 'shit', 's hit', 'sh1t', 'slut', 'smegma', 'spunk', 'tit', 'tosser', 'turd', 'twat', 'vagina', 'wank', 'whore', 'wtf');
		foreach($swearWords as $swearWord){
			$replace = substr($keywords, 0, 1);
			if($keywords == $swearWord){
				$censored = str_replace($swearWord, $replace.'***', $keywords);
				return $censored;
			}
		}
		return $keywords;
	}
	
	function censored($keywords){
		$swearWords = array('anal', 'anus', 'arse', 'ass', 'ballsack', 'balls', 'bastard', 'bitch', 'biatch', 'bloody', 'blowjob', 'blow job', 'bollock', 'bollok', 'boner', 'boob', 'bugger', 'bum', 'butt', 'buttplug', 'clitoris', 'cock', 'coon', 'crap', 'cunt', 'damn', 'dick', 'dildo', 'dyke', 'fag', 'feck', 'fellate', 'fellatio', 'felching', 'fuck', 'f u c k', 'fudgepacker', 'fudge packer', 'flange', 'Goddamn', 'God damn', 'hell', 'homo', 'jerk', 'jizz', 'knobend', 'knob end', 'labia', 'lmao', 'lmfao', 'muff', 'nigger', 'nigga', 'omg', 'penis', 'piss', 'poop', 'prick', 'pube', 'pussy', 'queer', 'scrotum', 'sex', 'shit', 's hit', 'sh1t', 'slut', 'smegma', 'spunk', 'tit', 'tosser', 'turd', 'twat', 'vagina', 'wank', 'whore', 'wtf');
		foreach($swearWords as $swearWord){
			$replace = substr($keywords, 0, 1);
			if($keywords == $swearWord){
				return true;
			}
		}
		return false;
	}
	
	function number($data){
		if(is_numeric($data)){
			return number_format($data);
		}else{
			return $data;
		}
	}
	
	function reading_file($file){
		if($handle=fopen($file, 'r')){
			foreach(file($file) as $content){
				echo trim($content);
			}
		}
	}

	function isNewLine($line) {
		return !strlen(trim($line));
	}
?>