<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Checkboxes extends Component
{
    const TEMPLATE = 'checkboxes';
    public $values;
    public bool $inline;
    public $options;

    public function __construct(
        string $name,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        string $size = null,
        string $values = null,
        bool $inline = false,

        array $options = null,
        $source = null
    ) {
        parent::__construct($name, $label, null, $id, $comment, $required, $size, null);

        if($this->model !== null) {
            $this->values = $this->model->$name->pluck('id')->toArray();
        } else {
            $this->values = is_array($values) ? $values : [$values];
        }

        $this->options = $options ?? $this->getOptionsFromSource($source);
        $this->inline = $inline;
    }
}
