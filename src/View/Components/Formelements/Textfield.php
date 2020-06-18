<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class Textfield extends Component
{
    public $type;
    public $name;
    public $id;
    public $legend;
    public $placeholder;
    public $value;
    public $size;
    public $required;

    public function __construct($name, $type = null, $id = null, $legend = null, $placeholder = null, $value = null, $size = null, $model = null, $required = null)
    {
        $this->name = $name;
        $this->type = $type ?? 'text';
        $this->id = $id ?? $name;
        $this->legend = $legend ?? ucfirst($name);
        $this->placeholder = $placeholder ?? '';
        $this->value = $model->$name ?? ($value ?? '');
        $this->size = $size ?? 'col-12';
        $this->required = $required ? '<span class="text-primary">*</span>' : '';
    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.textfield');
    }
}

