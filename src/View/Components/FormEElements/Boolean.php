<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Boolean extends Component
{
    const TEMPLATE = 'boolean';
    public string $legend;

    public function __construct(
        string $name,
        string $label = null,
        string $placeholder = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        string $value = null,
        string $legend = null
    ) {
        parent::__construct($name, $label, $placeholder, $id, $comment, $required, $size, $value, $disabled);
        $this->legend = $legend ?? '';
    }
}
