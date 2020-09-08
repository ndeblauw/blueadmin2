<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Radiobuttons extends Component
{
    const TEMPLATE = 'radiobuttons';

    public $options;
    public $inline;

    public function __construct(
        string $name,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        string $value = null,
        bool $inline = false,

        $options = null,
        $source = null
    ) {
        parent::__construct($name, $label, null, $id, $comment, $required, $size, $value, $disabled);
        $this->inline = $inline ? true : false;
        $this->options = $options ?? $this->getOptionsFromSource($source);
    }
}
