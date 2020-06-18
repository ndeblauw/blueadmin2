<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class Radiobuttons extends Component
{
    public $name;
    public $legend;
    public $size;
    public $value;
    public $options;
    public $required;
    public $inline;

    public function __construct($name, $options, $legend = null, $size = null, $value = null, $required = null, $model= null, $inline = null)
    {
        $this->name = $name;
        $this->legend = $legend ?? ucfirst($name);
        $this->size = $size ?? 'col-12 col-md-6';
        $this->value = $value ?? ($model->$name ?? '');
        $this->options = $options;
        $this->required = $required ? '<span class="text-primary">*</span>' : '';
        $this->inline = $inline ? true : false;
    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.radiobuttons');
    }
}
