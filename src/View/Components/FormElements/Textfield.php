<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Textfield extends Component
{
    const TEMPLATE = 'textfield';
    public string $type;

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
        string $type = null
    ) {
        parent::__construct($name, $label, $placeholder, $id, $comment, $required, $size, $value, $disabled);

        $this->type = $type ?? 'text';
    }
}
