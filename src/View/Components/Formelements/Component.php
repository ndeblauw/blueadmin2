<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component as BaseComponent;

abstract class Component extends BaseComponent
{
    use HandlesBoundModel;

    const TEMPLATE = '';
    const REQUIRED = '<span class="text-primary">*</span>';
    const SIZE = 'col-12 col-md-6';

    public string $name;
    public string $id;
    public string $label;
    public string $placeholder;
    public string $comment;
    public string $required;
    public string $size;
    public $model;
    public $value;

    public function __construct($name, $label, $placeholder, $id, $comment, $required, $size, $value, $bind = null)
    {
        // If ?prefil[name]=xxx in url, prefill the field - only if no value was explicitly given
        $prefill = Session::get('prefill', false);
        if (is_null($value) && $prefill) {
            $value = array_key_exists($name, $prefill) ? $prefill[$name] : $value;
        }

        $this->name = $name;
        $this->label = $label ?? ucfirst($name);
        $this->placeholder = $placeholder ?? '';
        $this->id = $id ?? $name;
        $this->comment = $comment ?? '';

        $this->required = $required ? $this::REQUIRED : '';
        $this->size = $size===null ? $this::SIZE : $size;

        $this->model = $this->getBoundTarget();
        $this->value = $value ?: $this->getBoundValue($bind, $name);
    }

    public function render()
    {
        return view('BlueAdminComponents::formelements.'.static::TEMPLATE);
    }


    protected function getOptionsFromSource(string $source = null)
    {
        if ($source===null) {
            abort(500, 'Either options or source needs to be set to use <x-ba-radiobuttons');
        }

        $Source = "\\App\\BlueAdmin\\" . $source;
        return $Source::getSelectValues();
    }
}
