<?php

namespace Ndeblauw\BlueAdmin;

class BlueAdminModel {

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