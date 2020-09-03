<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Textarea extends Component
{
    const TEMPLATE = 'textarea';

    public function __construct(
        string $name,
        string $label = null,
        string $placeholder = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        string $size = null,
        string $value = null
    ) {
        parent::__construct($name, $label, $placeholder, $id, $comment, $required, $size, $value);
    }
}