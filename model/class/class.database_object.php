<?php
require_once($dir_class.'class.database.php');

/**
* DatabaseObject
*/
class DatabaseObject {
	//error in accessing db_fields in attributes();
	public function save() {
		return isset($this->id) ? $this->update() : $this->create();
	}
}

?>