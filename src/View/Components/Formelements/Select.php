<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class Select extends Component
{
    public $id;
    public $value;
    public $legend;
    public $size;
    public $options;
    public $name;
    public $required;

    public function __construct($name, $options, $value = null, $legend = null, $size = null, $id = null, $model = null, $required = null)
    {
        $this->id = $id;
        $this->legend = $legend ?? ucfirst($name);
        $this->value = $model->$name ?? ($value ?? '');
        $this->size = $size ?? 'col-12 col-md-6';
        $this->options = $options;
        $this->name = $name;
        $this->required = $required ? '<span class="text-primary">*</span>' : '';
    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.select');
    }
}
