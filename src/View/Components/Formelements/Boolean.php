<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class Boolean extends Component
{
    public $id;
    public $name;
    public $legend;
    public $value;
    public $size;
    public $label;
    public $required;

    public function __construct($name, $label, $id = null, $legend = null, $value = null, $size = null, $model = null, $required = null)
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->legend = $legend ?? ucfirst($name);
        $this->value = $value ?? ($model->$name ?? false);
        $this->size = $size ?? 'col-12 col-md-6';
        $this->label = $label;
        $this->required = $required ? '<span class="text-primary">*</span>' : '';

        //dd($this->value);
    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.boolean');
    }
}
