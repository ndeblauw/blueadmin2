<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\View\Component;

class BelongsTo extends Component
{
    public $id;
    public $value;
    public $legend;
    public $size;
    public $options;
    public $name;
    public $required;

    public function __construct($name, $options = null, $source = null, $value = null, $legend = null, $size = null, $id = null, $model = null, $required = null)
    {
        $source = "\\App\\BlueAdmin\\" . $source;
        $field = $name . '_id';
        $this->id = $id;
        $this->legend = $legend ?? ucfirst($name);
        $this->name = $field;
        $this->value = $model->$field ?? ($value ?? '');
        $this->size = $size ?? 'col-12 col-md-6';

        $this->options = $options ?? $source::getSelectValues();
        $this->required = $required ? '<span class="text-primary">*</span>' : '';

    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.select');
    }
}
