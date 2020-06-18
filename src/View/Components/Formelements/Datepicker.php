<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class Datepicker extends Component
{
    public $legend;
    public $name;
    public $size;
    public $value;
    public $id;
    public $required;
    public $placeholder;


    public function __construct($name, $size = null, $value = null, $id = null, $placeholder = null, $legend = null, $model = null, $required = null)
    {
        $this->legend = $legend ?? ucfirst($name);;
        $this->name = $name;
        $this->size = $size ?? 'col-12 col-md-6';
        $this->placeholder = $placeholder ?? '';
        $this->id = $id ?? $name;
        $this->required = $required ? '<span class="text-primary">*</span>' : '';
        $this->value = $model->$name ?? ($value ?? '');
    }


    public function render()
    {
        return view('BlueAdminComponents::formelements.datepicker');
    }
}
