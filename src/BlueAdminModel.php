<?php

namespace Ndeblauw\BlueAdmin;

class BlueAdminModel {

	public $nullable_fields = [];

	public function index_columns()
	{
        // If defined, use definition
        if( isset($this->indexColumns) ){
            $columns = [];
            foreach($this->fields as $field => $details) {

                if(! in_array($field,$this->indexColumns) )
                    continue;

                $title = isset($details['title'])
                    ? $details['title']
                    : (  (strpos($field, '.') == false) ? ucfirst($field) : ucfirst( substr( strrchr($field, '.'), 1) ));	// get the last part of a dot notation, with a capital

                $columns[] = (object) [
                    'title' => $title,
                    'value' => $field,
                    'type' => $details['type'],
                    'format' => $details['format'] ?? '',
                    'field' => $details['field'] ?? null,
                ];
            }
            return collect($columns);
        }


		if ( isset($this->fields) ) {
            $columns = [];
            foreach($this->fields as $field => $details) {

                $title = isset($details['title'])
                    ? $details['title']
                    : (  (strpos($field, '.') == false) ? ucfirst($field) : ucfirst( substr( strrchr($field, '.'), 1) ));	// get the last part of a dot notation, with a capital

                $columns[] = (object) [
                    'title' => $title,
                    'value' => $field,
                    'type' => $details['type'],
                ];
            }
            return collect($columns);
        }



        // TO-DO, this OLD STYLE, DEPRECATED thus PHASE OUT
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

	public function index_initial_ordering()
    {
        if( isset($this->index_orderby) ) {
            if(! is_array($this->index_orderby) ) {
                return ['column' => $this->index_orderby, 'order' => 'asc' ];
            }

            return $this->index_orderby;
        }

        return ['column' => 0, 'order' => 'asc'];
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
