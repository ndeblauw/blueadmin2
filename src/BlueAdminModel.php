<?php

namespace Ndeblauw\BlueAdmin;

class BlueAdminModel {

	public function widgets()
	{
		if(!isset($this->widgets))
			return [];
		
		return array_map(function($val) { return 'App\BlueAdmin\Widgets\\' . $val;} , $this->widgets);
	}

	
}