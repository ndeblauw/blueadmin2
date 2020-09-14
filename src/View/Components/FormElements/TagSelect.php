<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class TagSelect extends Component
{
    const TEMPLATE = 'tagselect';

    public $options;
    public $inline;
    public $values;

    public function __construct(
        string $name,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        $values = null,

        $options = null,
        $source = null
    ) {
        parent::__construct($name, $label, null, $id, $comment, $required, $size, null, $disabled);
        $this->values = $values;
        $this->options = $options ?? $this->getOptionsFromSource($source);
    }
}
