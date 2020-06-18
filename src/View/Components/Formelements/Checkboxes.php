<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class Checkboxes extends Component
{
    public $id;
    public $name;
    public $legend;
    public $values;
    public $size;
    public $options;
    public $required;

    public function __construct($name, $options, $id = null, $legend = null, $values = null, $size = null, $required = null, $inline = null)
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->legend = $legend ?? ucfirst($name);
        $this->values = is_array($values) ? $values : [$values];  // $value ?? ($model->$name ?? '');
        $this->size = $size ?? 'col-12 col-md-6';
        $this->options = $options;
        $this->required = $required ? '<span class="text-primary">*</span>' : '';
        $this->inline = $inline ? true : false;
    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.checkboxes');
    }
}
