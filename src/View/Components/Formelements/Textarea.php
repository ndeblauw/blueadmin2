<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $name;
    public $id;
    public $legend;
    public $placeholder;
    public $value;
    public $size;
    public $required;

    public function __construct($name, $id = null, $legend = null, $placeholder = null, $value = null, $size = null, $model = null, $required = null)
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->legend = $legend ?? ucfirst($name);
        $this->placeholder = $placeholder;
        $this->size = $size ?? 'col-12';
        $this->required = $required ? '<span class="text-primary">*</span>' : '';
        $this->value = $model->$name ?? ($value ?? '');
    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.textarea');
    }
}
