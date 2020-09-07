<?php

namespace Ndeblauw\BlueAdmin\View\Components\FormElements;

class BelongsTo extends Component
{
    const TEMPLATE = 'select';
    public $options;
    public $allowNullOption;

    public function __construct(
        string $name,
        string $label = null,
        string $comment = null,
        string $id = null,
        bool $required = false,
        bool $disabled = false,
        string $size = null,
        string $value = null,
        $options = null,
        $source = null,
        $allowNullOption = null
    ) {
        $name = $name.'_id';
        parent::__construct($name, $label, null, $id, $comment, $required, $size, $value, $disabled);
        $this->options = $options ?? $this->getOptionsFromSource($source);
        $this->allowNullOption = (isset($allowNullOption)) ? true : false;
    }
}
