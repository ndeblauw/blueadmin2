<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class Select2 extends Component
{
    const TEMPLATE = 'select2';

    public $options;
    public $allowNullOption;

    public function __construct(
        string $name,
        array $options,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        string $value = null,
        bool $allowNullOption = false
    ) {
        parent::__construct($name, $label, null, $id, $comment, $required, $size, $value, $disabled);
        $this->options = $options;
        $this->allowNullOption = ($allowNullOption) ? true : false;
    }
}
