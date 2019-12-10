<?php

namespace Ndeblauw\BlueAdmin;

class BlueAdminModel {

	public function index_columns() 
	{
		if( isset($this->index_fields) ) {
			$columns = [];
			foreach($this->index_fields as $title => $type) { 
				$columns[] = (object) [
					'title' => (strpos($title, '.') == false) ? ucfirst($title) : ucfirst( substr( strrchr($title, '.'), 1) ),	// get the last part of a dot notation, with a capital
					'value' => $title,
					'type' => $type
					]; 
			}

			return collect($columns);
		}


	}

	public function index_actions_column_nr () {
		return count($this->index_columns());
	}

	public function index_eager_load() {
		if( isset($this->index_eager_load))
			return $this->index_eager_load;
		
		return [];
	}

	public function widgets()
	{
		if(!isset($this->widgets))
			return [];
		
		return array_map(function($val) { return 'App\BlueAdmin\Widgets\\' . $val;} , $this->widgets);
	}


	public function mediafiles()
	{
		if(!isset($this->to_media_file))
			return [];

		return $this->to_media_file;
	}
	
}